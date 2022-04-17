variable "digital_ocean_access_token" {
    type = string
}

variable "aws_access_key" {
    type = string
}

variable "aws_secret_key" {
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

variable "app_php_docker_image" {
    type = string
}

variable "app_server_docker_image" {
    type = string
}

variable "aws_s3_thumbnail_bucket_name" {
    type = string
    default = "thumbnails.arminek.s3.bucket"
}
