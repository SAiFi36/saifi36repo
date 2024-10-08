pipeline {
  agent any
  environment {
    // Define environment variables for Docker Hub credentials and image details
    DOCKER_HUB_CREDENTIALS_ID = 'dockerhub'
    DOCKER_IMAGE_NAME = 'saifi36/project'
    DOCKER_IMAGE_TAG = 'latest'
    KUBERNETES_SSH_CREDENTIALS_ID = 'kubernetes-ssh-credentials-id'
    KUBERNETES_MASTER_IP = '172.31.45.222'
    KUBERNETES_DEPLOYMENT_NAME = 'saifi36/proj'
    SERVICE_NAME = 'saifi36-service'
    DEPLOYMENT_NAME = 'saifi36-deployment'
    DEPLOYMENT_FILE = "~/dep.yaml"
    SERVICE_FILE = "~/exp.yaml"
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
    stage('Scan Image with Trivy') {
      steps {
        script {
          sh "trivy image --format json --output trivy-report.json ${DOCKER_IMAGE_NAME}:${DOCKER_IMAGE_TAG}"
        }
      }
    }
    stage('Push Docker Image to Docker Hub') {
      steps {
        script {
          echo "Logging into Docker Hub"
          withCredentials([usernamePassword(credentialsId: DOCKER_HUB_CREDENTIALS_ID, usernameVariable: 'DOCKER_USERNAME', passwordVariable: 'DOCKER_PASSWORD')]) {
            sh "echo $DOCKER_PASSWORD | docker login -u $DOCKER_USERNAME --password-stdin"
          }
          echo "Pushing Docker image: ${DOCKER_IMAGE_NAME}:${DOCKER_IMAGE_TAG}"
          sh "docker push ${DOCKER_IMAGE_NAME}:${DOCKER_IMAGE_TAG}"
          echo "Logging out from Docker Hub"
          sh "docker logout"
        }
      }
    }
    stage('Run Commands on Kubernetes Master to DEPLOY IMAGE on CLUSTER') {
      steps {
        script {
          echo "Connecting to Kubernetes control plane via SSH"
          sh """
          # Copy YAML files to Kubernetes master home directory
          scp -o StrictHostKeyChecking=no exp.yaml dep.yaml admin@${KUBERNETES_MASTER_IP}:~/

          ssh -o StrictHostKeyChecking=no admin@${KUBERNETES_MASTER_IP} << 'EOF'
          # Update the image in dep.yaml
          sed -i 's|image: .*/.*|image: ${DOCKER_IMAGE_NAME}:${DOCKER_IMAGE_TAG}|g' ~/dep.yaml

          # Apply deployment configuration
kubectl apply -f ${DEPLOYMENT_FILE}

# Check if the deployment exists
if kubectl get deployments | grep -q ${DEPLOYMENT_NAME}; then
  echo "Deployment exists, restarting the rollout"
  kubectl rollout restart deployment/${DEPLOYMENT_NAME}
else
  echo "Deployment does not exist, creating deployment"
  kubectl apply -f ${DEPLOYMENT_FILE}
fi

# Wait for the rollout to complete
echo "Waiting for deployment rollout to finish..."
kubectl rollout status deployment/${DEPLOYMENT_NAME}

# Apply service configuration to expose deployment
kubectl apply -f ${SERVICE_FILE}

# Expose deployment (if needed)
#kubectl expose deployment ${DEPLOYMENT_NAME} --type=NodePort

# Check the status of the deployment and service
kubectl get deployments
kubectl get services

        
          """
        }
      }
    }
  }
}
