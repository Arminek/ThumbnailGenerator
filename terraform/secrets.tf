resource "kubernetes_secret" "aws" {
    metadata {
        name = "aws"
        namespace = "default"
    }

    data = {
        access_key = var.aws_access_key
        secret_key = var.aws_secret_key
    }
}
