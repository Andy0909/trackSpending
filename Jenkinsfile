pipeline {
    agent any
    environment {
        AWS_ACCOUNT_ID = "422351898213"
        AWS_DEFAULT_REGION = "ap-northeast-1"
        IMAGE_REPO_NAME = "php"
        IMAGE_TAG = "latest"
        REPOSITORY_URI = "422351898213.dkr.ecr.ap-northeast-1.amazonaws.com/php"
        CLUSTER = "phpProjectCluster"
        SERVICE = "trackspending-service"
    }
   
    stages {
        
        stage('Cloning Git') {
            steps {
                checkout([$class: 'GitSCM', branches: [[name: '*/master']], doGenerateSubmoduleConfigurations: false, extensions: [], submoduleCfg: [], userRemoteConfigs: [[credentialsId: '', url: 'https://github.com/Andy0909/trackSpending.git']]])     
            }
        }

        stage('Setup') {
            steps {
                script {
                    // Install PHP and Composer
                    sh '''
                        # Update package list and install necessary tools
                        apt-get update
                        apt-get install -y php php-cli php-mbstring unzip curl git

                        # Install Composer
                        curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
                    '''
                }
            }
        }

        stage('Install Dependencies') {
            steps {
                script {
                    sh 'composer install --no-dev --prefer-dist --optimize-autoloader'
                }
            }
        }

        stage('Run Tests') {
            steps {
                script {
                    sh 'php artisan test'
                }
            }
        }

        stage('Logging into AWS ECR') {
            steps {
                script {
                    sh """aws ecr get-login-password --region ${AWS_DEFAULT_REGION} | docker login --username AWS --password-stdin ${AWS_ACCOUNT_ID}.dkr.ecr.${AWS_DEFAULT_REGION}.amazonaws.com"""
                }  
            }
        }
        
        stage('Building image') {
            steps {
                script {
                    sh """ docker build -t ${IMAGE_REPO_NAME}:${IMAGE_TAG} ."""
                }
            }
        }
   
        stage('Pushing to ECR') {
            steps {  
                script {
                    sh """docker tag ${IMAGE_REPO_NAME}:${IMAGE_TAG} ${REPOSITORY_URI}:${IMAGE_TAG}"""
                    sh """docker push ${AWS_ACCOUNT_ID}.dkr.ecr.${AWS_DEFAULT_REGION}.amazonaws.com/${IMAGE_REPO_NAME}:${IMAGE_TAG}"""
                }
            }
        }

        stage('Deploy to ECS') {
            steps {
                script {
                    sh """aws ecs update-service --cluster ${CLUSTER} --service ${SERVICE} --force-new-deployment"""
                }
            }
        }
    }
}