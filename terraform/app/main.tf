data "kubernetes_service_v1" "ingress_controller" {
    metadata {
        namespace = var.nginx_namespace
        name      = var.nginx_controller_name
    }
}

data "kubernetes_namespace_v1" "module_namespace" {
    metadata {
        name = var.module_namespace
    }
}

resource "digitalocean_record" "main" {
    depends_on = [data.kubernetes_service_v1.ingress_controller]
    domain     = var.main_domain
    type       = "A"
    name       = var.sub_domain
    value      = data.kubernetes_service_v1.ingress_controller.status[0].load_balancer[0].ingress[0].ip
}

resource "digitalocean_record" "main_www" {
    depends_on = [digitalocean_record.main]
    domain     = var.main_domain
    name       = format("www.%s", var.sub_domain)
    type       = "CNAME"
    value      = format("%s.%s.", var.sub_domain, var.main_domain)
}
