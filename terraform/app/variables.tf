variable "main_domain" {
    type = string
}

variable "sub_domain" {
    type = string
}

variable "cluster_name" {
    type = string
}

variable "digital_ocean_access_token" {
    type = string
}

variable "nginx_namespace" {
    type    = string
    default = "nginx-controller"
}

variable "nginx_controller_name" {
    type    = string
    default = "ingress-nginx-controller"
}

variable "module_namespace" {
    type    = string
    default = "thumbnail-generator"
}

variable "app_name" {
    type    = string
    default = "thumbnail-generator-api"
}

variable "env" {
    type    = string
    default = "prod"
}

variable "app_php_docker_image" {
    type = string
}

variable "app_server_docker_image" {
    type = string
}

variable "aws_access_key" {
    type = string
}

variable "aws_secret_key" {
    type = string
}

variable "aws_s3_thumbnail_bucket_name" {
    type = string
}
