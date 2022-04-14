variable "cluster_name" {
    type    = string
    default = "main"
}

variable "digital_ocean_access_token" {
    type = string
}

variable "module_namespace" {
    type    = string
    default = "thumbnail-generator"
}

variable "ghcr_username" {
    type = string
}

variable "ghcr_password" {
    type = string
}

variable "ghcr_email" {
    type = string
}
