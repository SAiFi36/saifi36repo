pipeline {
        agent any

        environment {
                // Define environment variables for Docker Hub credentials
                DOCKER_HUB_CREDENTIALS_ID = 'dockerhub'
                DOCKER_IMAGE_NAME = 'apache2'
                DOCKER_IMAGE_TAG = 'latest'
                KUBERNETES_SSH_CREDENTIALS_ID = 'kubernetes-ssh-credentials-id'
                KUBERNETES_MASTER_IP = 'your-kubernetes-master-ip'
                KUBERNETES_DEPLOYMENT_NAME = 'saifi36/proj'
                KUBERNETES_NAMESPACE = 'default' // Change as needed
        }

        stages {
                stage('Build Docker Image') {
                        steps {
                                script {
                                        // Build Docker image
                                        sh "docker build -t ${DOCKER_IMAGE_NAME}:${DOCKER_IMAGE_TAG} ."
                                }
                        }
                }

                stage('Push Docker Image to Docker Hub') {
                        steps {
                                script {
                                        // Login to Docker Hub
                                        withDockerRegistry(credentialsId: DOCKER_HUB_CREDENTIALS_ID, url: 'https://index.docker.io/v1/') {
                                                // Push Docker image
                                                sh "docker push ${DOCKER_IMAGE_NAME}:${DOCKER_IMAGE_TAG}"
                                        }
                                }
                        }
                }
        }

        post {
                always {
                        // Clean up any Docker images from the agent
                        sh "docker system prune -af"
                }
        }
}
