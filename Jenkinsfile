pipeline {
    agent any

    environment {
        // Define environment variables for Docker Hub credentials and image details
        DOCKER_HUB_CREDENTIALS_ID = 'dockerhub'
        DOCKER_IMAGE_NAME = 'saifi36/kkl'
        DOCKER_IMAGE_TAG = 'latest'
        KUBERNETES_SSH_CREDENTIALS_ID = 'kubernetes-ssh-credentials-id'
        KUBERNETES_MASTER_IP = '172.31.13.20'
        KUBERNETES_DEPLOYMENT_NAME = 'saifi36/proj'
        SERVICE_NAME = 'my-app-service'
        DEPLOYMENT_NAME = 'my-app-deployment'  
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

        stage('Run Commands on Kubernetes Master') {
            steps {
                script {
                    echo "Connecting to Kubernetes control plane via SSH"
                        sh """
                        ssh -o StrictHostKeyChecking=no admin@${KUBERNETES_MASTER_IP} << 'EOF'
                        # Update the image in dep.yaml
                        sed -i 's|image: .*/.*|image: ${DOCKER_IMAGE_NAME}:${DOCKER_IMAGE_TAG}|g' ~/dep.yaml

                        # Apply deployment configuration
                        kubectl apply -f ~/dep.yaml

                        # Check if the deployment exists
                        if kubectl get deployments | grep -q ${DEPLOYMENT_NAME}; then
                            echo "Deployment exists, rolling out new image"
                            kubectl rollout restart deployment/${DEPLOYMENT_NAME}
                            kubectl rollout status deployment/${DEPLOYMENT_NAME}
                        else
                            echo "Deployment does not exist, creating deployment"
                            kubectl apply -f ~/dep.yaml
                        fi

                        # Apply service configuration to expose deployment
                        kubectl apply -f ~/exp.yaml

                        # Optional: Check the status of the deployment and service
                        kubectl get deployments
                        kubectl get services

                        # Get the external IP of the LoadBalancer service
                        SERVICE_IP=\$(kubectl get services ${SERVICE_NAME} --output=jsonpath='{.status.loadBalancer.ingress[0].ip}')
                        echo "Service IP: \${SERVICE_IP}"

                        # Get the IPs of the pods
                        POD_IPS=\$(kubectl get pods -l app=${DOCKER_IMAGE_NAME} -o jsonpath='{.items[*].status.podIP}')
                        echo "Pod IPs: \${POD_IPS}"

                        
                        """
                    }
                }
            }
        }
    }

    
