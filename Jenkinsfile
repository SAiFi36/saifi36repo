pipeline {
    agent any

    environment {
        // Define environment variables for Docker Hub credentials and image details
        DOCKER_HUB_CREDENTIALS_ID = 'dockerhub'
        DOCKER_IMAGE_NAME = 'saifi36/kkl'
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
                    echo "Building Docker image: ${DOCKER_IMAGE_NAME}:${DOCKER_IMAGE_TAG}"
                    sh "docker build -t ${DOCKER_IMAGE_NAME}:${DOCKER_IMAGE_TAG} ."
                }
            }
        }

        stage('Push Docker Image to Docker Hub') {
            steps {
                script {
                    echo "Logging into Docker Hub"
                    withCredentials([usernamePassword(credentialsId: DOCKER_HUB_CREDENTIALS_ID, usernameVariable: 'DOCKER_USERNAME', passwordVariable: 'DOCKER_PASSWORD')]) {
                        sh 'echo $DOCKER_PASSWORD | docker login -u $DOCKER_USERNAME --password-stdin'
                    }
                    echo "Pushing Docker image: ${DOCKER_IMAGE_NAME}:${DOCKER_IMAGE_TAG}"
                    sh "docker push ${DOCKER_IMAGE_NAME}:${DOCKER_IMAGE_TAG}"
                    echo "Logging out from Docker Hub"
                    sh "docker logout"
                }
            }
        }

        
        }
    }

    post {
        always {
            echo "Cleaning up Docker resources"
            sh "docker system prune -af"
        }
        success {
            echo "Pipeline completed successfully"
        }
        failure {
            echo "Pipeline failed"
        }
    }

