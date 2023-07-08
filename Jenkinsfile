pipeline {
    agent any
  
    environment {
        registry = "422351898213.dkr.ecr.ap-northeast-1.amazonaws.com/php-docker-image"
    }

    stages {
        stage("CICD start") {
            steps {
                echo 'CICD start'
            }
        }

        /*stage('Building image') {
            steps {
                sh 'docker build -t php-docker-image .'
            }
        }

        stage('Push to ECR') {
            steps {
                script {
                    sh 'aws ecr get-login-password --region us-east-1 | docker login --username AWS --password-stdin 422351898213.dkr.ecr.us-east-1.amazonaws.com'
                    sh 'docker push 422351898213.dkr.ecr.us-east-1.amazonaws.com/php-docker-image:latest'
                }
            }
        }*/
    }
}
