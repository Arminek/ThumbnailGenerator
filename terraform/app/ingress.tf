resource "kubernetes_ingress_v1" "main" {
    depends_on             = [
        data.kubernetes_namespace_v1.module_namespace, kubernetes_deployment_v1.main, kubernetes_service_v1.main
    ]
    wait_for_load_balancer = true
    metadata {
        name        = var.app_name
        namespace   = var.module_namespace
        annotations = {
            "kubernetes.io/ingress.class" : "nginx"
            "cert-manager.io/issuer" : "letsencrypt"
        }
    }

    spec {
        rule {
            host = format("%s.%s", var.sub_domain, var.main_domain)
            http {
                path {
                    backend {
                        service {
                            name = var.app_name
                            port {
                                number = 80
                            }
                        }
                    }
                    path      = "/"
                    path_type = "Prefix"
                }
            }
        }
        rule {
            host = format("www.%s.%s", var.sub_domain, var.main_domain)
            http {
                path {
                    backend {
                        service {
                            name = var.app_name
                            port {
                                number = 80
                            }
                        }
                    }
                    path      = "/"
                    path_type = "Prefix"
                }
            }
        }

        tls {
            hosts = [
                format("*.%s", var.main_domain),
                format("%s", var.main_domain),
                format("*.%s.%s", var.sub_domain, var.main_domain),
                format("%s.%s", var.sub_domain, var.main_domain),
            ]
            secret_name = "secret-tls"
        }
    }
}

