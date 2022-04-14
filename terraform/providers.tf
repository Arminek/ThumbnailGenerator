data "digitalocean_kubernetes_cluster" "fra1" {
    name = "main"
}

data "digitalocean_kubernetes_cluster" "sgp1" {
    name = "singapore-1"
}

data "digitalocean_kubernetes_cluster" "nyc1" {
    name = "new-york-1"
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

provider "kubernetes" {
    host                   = data.digitalocean_kubernetes_cluster.sgp1.endpoint
    cluster_ca_certificate = base64decode(data.digitalocean_kubernetes_cluster.sgp1.kube_config[0].cluster_ca_certificate)
    token                  = data.digitalocean_kubernetes_cluster.sgp1.kube_config[0].token
    alias                  = "sgp1"
}

provider "kubectl" {
    host                   = data.digitalocean_kubernetes_cluster.sgp1.endpoint
    cluster_ca_certificate = base64decode(data.digitalocean_kubernetes_cluster.sgp1.kube_config[0].cluster_ca_certificate)
    token                  = data.digitalocean_kubernetes_cluster.sgp1.kube_config[0].token
    load_config_file       = false
    alias                  = "sgp1"
}

provider "helm" {
    kubernetes {
        host                   = data.digitalocean_kubernetes_cluster.sgp1.endpoint
        cluster_ca_certificate = base64decode(data.digitalocean_kubernetes_cluster.sgp1.kube_config[0].cluster_ca_certificate)
        token                  = data.digitalocean_kubernetes_cluster.sgp1.kube_config[0].token
    }
    alias = "sgp1"
}

provider "kubernetes" {
    host                   = data.digitalocean_kubernetes_cluster.nyc1.endpoint
    cluster_ca_certificate = base64decode(data.digitalocean_kubernetes_cluster.nyc1.kube_config[0].cluster_ca_certificate)
    token                  = data.digitalocean_kubernetes_cluster.nyc1.kube_config[0].token
    alias                  = "nyc1"
}

provider "kubectl" {
    host                   = data.digitalocean_kubernetes_cluster.nyc1.endpoint
    cluster_ca_certificate = base64decode(data.digitalocean_kubernetes_cluster.nyc1.kube_config[0].cluster_ca_certificate)
    token                  = data.digitalocean_kubernetes_cluster.nyc1.kube_config[0].token
    load_config_file       = false
    alias                  = "nyc1"
}

provider "helm" {
    kubernetes {
        host                   = data.digitalocean_kubernetes_cluster.nyc1.endpoint
        cluster_ca_certificate = base64decode(data.digitalocean_kubernetes_cluster.nyc1.kube_config[0].cluster_ca_certificate)
        token                  = data.digitalocean_kubernetes_cluster.nyc1.kube_config[0].token
    }
    alias = "nyc1"
}
