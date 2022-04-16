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
    providers                  = {
        kubernetes = kubernetes.fra1
        helm       = helm.fra1
        kubectl    = kubectl.fra1
    }
}
