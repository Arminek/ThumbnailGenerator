resource "kubernetes_namespace_v1" "module_namespace" {
    metadata {
        name = var.module_namespace
    }
}

resource "kubernetes_secret_v1" "digitalocean_dns" {
    depends_on = [kubernetes_namespace_v1.module_namespace]
    metadata {
        name      = "digitalocean-dns"
        namespace = var.module_namespace
    }
    data = {
        access-token : var.digital_ocean_access_token
    }
}

resource "kubectl_manifest" "letsencrypt_issuer" {
    depends_on = [kubernetes_namespace_v1.module_namespace]
    yaml_body  = file("${path.module}/issuer.yml")
}

resource "kubernetes_secret_v1" "github_registry" {
    depends_on = [kubernetes_namespace_v1.module_namespace]
    metadata {
        name      = "github-registry"
        namespace = var.module_namespace
    }

    data = {
        ".dockerconfigjson" = jsonencode({
            auths = {
                "ghcr.io" = {
                    username = var.ghcr_username
                    password = var.ghcr_password
                    email    = var.ghcr_email
                }
            }
        })
    }

    type = "kubernetes.io/dockerconfigjson"
}
