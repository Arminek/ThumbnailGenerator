terraform {
    required_version = ">= 0.13.1"

    required_providers {
        digitalocean = {
            source  = "digitalocean/digitalocean"
            version = "2.17.0"
        }
        kubernetes = {
            source  = "hashicorp/kubernetes"
            version = "2.7.1"
        }
        kubectl = {
            source  = "gavinbunney/kubectl"
            version = "1.13.1"
        }
    }
}
