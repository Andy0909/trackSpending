pipeline {
    agent any
  
    stages {
        stage("CICD start") {
            steps {
                echo 'CICD start'
            }
        }

        stage ('Run Docker Compose') {
            steps{
                sh 'sudo docker-compose up -d'
            }
        }
    }
}
