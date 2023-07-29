pipeline {
    agent any
  
    stages {
        stage("CICD start") {
            steps {
                echo 'CICD start'
            }
        }

        stage('Build Docker Image') {
            steps {
                // 使用Dockerfile建構映像檔
                script {
                    def dockerImage = docker.build('php-image:latest', '-f Dockerfile .')
                    dockerImage.push()
                }
            }
        }
    }
}
