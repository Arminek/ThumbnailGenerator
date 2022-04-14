terraform {
    backend "remote" {
        organization = "rocket-arminek"

        workspaces {
            name = "thumbnail-generator"
        }
    }
}
