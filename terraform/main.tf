module "app_fra1" {
    source                     = "./app"
    digital_ocean_access_token = var.digital_ocean_access_token
    ghcr_username              = var.ghcr_username
    ghcr_password              = var.ghcr_password
    ghcr_email                 = var.ghcr_email
    app_php_docker_image       = var.app_php_docker_image
    app_server_docker_image    = var.app_server_docker_image
    cluster_name               = "main"
    main_domain                = "arminek.xyz"
    sub_domain                 = "fra1-thumbnail"
    module_namespace = "default"
    aws_access_key = var.aws_access_key
    aws_secret_key = var.aws_secret_key
    aws_s3_thumbnail_bucket_name = var.aws_s3_thumbnail_bucket_name
    providers                  = {
        kubernetes = kubernetes.fra1
        helm       = helm.fra1
        kubectl    = kubectl.fra1
    }
}

module "aws_s3_bucket_fra1" {
    source = "./aws_s3_bucket"
    bucket = var.aws_s3_thumbnail_bucket_name
    acl = "public-read"
    providers = {
        aws = aws.fra1
    }
}
