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
    sub_domain                 = "fra1.thumbnail"
    module_namespace = "default"
    providers                  = {
        kubernetes = kubernetes.fra1
        helm       = helm.fra1
        kubectl    = kubectl.fra1
    }
}

module "app_nyc1" {
    count = 0
    source                     = "./app"
    digital_ocean_access_token = var.digital_ocean_access_token
    ghcr_username              = var.ghcr_username
    ghcr_password              = var.ghcr_password
    ghcr_email                 = var.ghcr_email
    app_php_docker_image       = var.app_php_docker_image
    app_server_docker_image    = var.app_server_docker_image
    cluster_name               = "new-york-1"
    main_domain                = "arminek.xyz"
    sub_domain                 = "nyc1.thumbnail"
    module_namespace = "default"
    providers                  = {
        kubernetes = kubernetes.nyc1
        helm       = helm.nyc1
        kubectl    = kubectl.nyc1
    }
}

module "app_sgp1" {
    count = 0
    source                     = "./app"
    digital_ocean_access_token = var.digital_ocean_access_token
    ghcr_username              = var.ghcr_username
    ghcr_password              = var.ghcr_password
    ghcr_email                 = var.ghcr_email
    app_php_docker_image       = var.app_php_docker_image
    app_server_docker_image    = var.app_server_docker_image
    cluster_name               = "singapore-1"
    main_domain                = "arminek.xyz"
    sub_domain                 = "sgp1.thumbnail"
    module_namespace = "default"
    providers                  = {
        kubernetes = kubernetes.sgp1
        helm       = helm.sgp1
        kubectl    = kubectl.sgp1
    }
}
