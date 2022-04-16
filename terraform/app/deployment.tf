resource "kubernetes_deployment_v1" "main" {
    depends_on       = [data.kubernetes_namespace_v1.module_namespace]
    wait_for_rollout = false
    metadata {
        name      = var.app_name
        namespace = var.module_namespace
        labels    = {
            env = var.env
            app = var.app_name
        }
    }

    spec {
        replicas = 1

        selector {
            match_labels = {
                env = var.env
                app = var.app_name
            }
        }

        template {
            metadata {
                labels = {
                    env = var.env
                    app = var.app_name
                }
            }

            spec {
                volume {
                    name = "php-socket"
                    empty_dir {}
                }
                volume {
                    name = "caddy-data"
                    empty_dir {}
                }
                volume {
                    name = "caddy-config"
                    empty_dir {}
                }

                container {
                    image_pull_policy = "Always"
                    image             = lower(var.app_server_docker_image)
                    name              = "server"
                    env {
                        name = "MERCURE_PUBLISHER_JWT_KEY"
                        value = "!ChangeMe!"
                    }
                    env {
                        name = "MERCURE_SUBSCRIBER_JWT_KEY"
                        value = "!ChangeMe!"
                    }
                    env {
                        name = "SERVER_NAME"
                        value = ":80"
                    }
                    volume_mount {
                        mount_path = "/var/run/php"
                        name       = "php-socket"
                    }
                    volume_mount {
                        mount_path = "/data"
                        name       = "caddy-data"
                    }
                    volume_mount {
                        mount_path = "/config"
                        name       = "caddy-config"
                    }
                    port {
                        container_port = 80
                    }
                    resources {
                        limits = {
                            cpu    = "0.5"
                            memory = "256Mi"
                        }
                        requests = {
                            cpu    = "0.3"
                            memory = "128Mi"
                        }
                    }
                    liveness_probe {
                        http_get {
                            scheme = "HTTP"
                            path = "/v1/greetings/world"
                            port = 80
                        }

                        initial_delay_seconds = 10
                        period_seconds        = 10
                    }
                }
                container {
                    image_pull_policy = "Always"
                    image             = lower(var.app_php_docker_image)
                    name              = "php"
                    volume_mount {
                        mount_path = "/var/run/php"
                        name       = "php-socket"
                    }
                    env {
                        name = "AWS_ACCESS_KEY_ID"
                        value_from {
                            secret_key_ref {
                                name = "aws"
                                key = "access_key"
                            }
                        }
                    }
                    env {
                        name = "AWS_SECRET_ACCESS_KEY"
                        value_from {
                            secret_key_ref {
                                name = "aws"
                                key = "secret_key"
                            }
                        }
                    }
                    env {
                        name = "MERCURE_JWT_SECRET"
                        value = "!ChangeMe!"
                    }
                    env {
                        name = "APP_ENV"
                        value = var.env
                    }
                    env {
                        name = "APP_SECRET"
                        value = "!ChangeMe!"
                    }
                    port {
                        container_port = 9000
                    }
                    resources {
                        limits = {
                            cpu    = "0.5"
                            memory = "512Mi"
                        }
                        requests = {
                            cpu    = "0.3"
                            memory = "256Mi"
                        }
                    }
                }
                image_pull_secrets {
                    name = "github-registry"
                }
            }
        }
    }
}
