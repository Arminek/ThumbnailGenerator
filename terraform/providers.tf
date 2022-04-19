data "digitalocean_kubernetes_cluster" "fra1" {
    name = "main"
}

provider "digitalocean" {
    token = var.digital_ocean_access_token
}

provider "kubernetes" {
    host                   = data.digitalocean_kubernetes_cluster.fra1.endpoint
    cluster_ca_certificate = base64decode(data.digitalocean_kubernetes_cluster.fra1.kube_config[0].cluster_ca_certificate)
    token                  = data.digitalocean_kubernetes_cluster.fra1.kube_config[0].token
    alias                  = "fra1"
}

provider "kubectl" {
    host                   = data.digitalocean_kubernetes_cluster.fra1.endpoint
    cluster_ca_certificate = base64decode(data.digitalocean_kubernetes_cluster.fra1.kube_config[0].cluster_ca_certificate)
    token                  = data.digitalocean_kubernetes_cluster.fra1.kube_config[0].token
    load_config_file       = false
    alias                  = "fra1"
}

provider "helm" {
    kubernetes {
        host                   = data.digitalocean_kubernetes_cluster.fra1.endpoint
        cluster_ca_certificate = base64decode(data.digitalocean_kubernetes_cluster.fra1.kube_config[0].cluster_ca_certificate)
        token                  = data.digitalocean_kubernetes_cluster.fra1.kube_config[0].token
    }
    alias = "fra1"
}

provider "aws" {
    region = "eu-central-1"
    access_key = var.aws_access_key
    secret_key = var.aws_secret_key
    alias = "fra1"
}
