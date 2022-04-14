resource "kubernetes_service_v1" "main" {
    depends_on = [data.kubernetes_namespace_v1.module_namespace, kubernetes_deployment_v1.main]
    metadata {
        name      = var.app_name
        namespace = var.module_namespace
        labels    = {
            env = var.env
            app = var.app_name
        }
    }
    spec {
        selector = {
            app = var.app_name
            env = var.env
        }
        port {
            port        = 80
            protocol    = "TCP"
            target_port = 80
        }

        type = "NodePort"
    }
}
