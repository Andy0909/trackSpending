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
        SUBNET_ID = "subnet-0dad19b25801c253a" // 替換為您的子網ID
        SECURITY_GROUP_ID = "sg-08c0bc7601a52735d" // 替換為您的安全組ID
        CONTAINER_NAME = "php" // 替換為您的容器名稱
    }
   
    stages {
        
        stage('Cloning Git') {
            steps {
                checkout([$class: 'GitSCM', branches: [[name: '*/master']], doGenerateSubmoduleConfigurations: false, extensions: [], submoduleCfg: [], userRemoteConfigs: [[credentialsId: '', url: 'https://github.com/Andy0909/trackSpending.git']]])     
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

        stage('Run Migrations') {
            steps {
                script {
                    def taskDefinition = sh(script: """
                        aws ecs describe-services --cluster ${CLUSTER} --services ${SERVICE} --query "services[0].taskDefinition" --output text --region ${AWS_DEFAULT_REGION}
                    """, returnStdout: true).trim()

                    def taskArn = sh(script: """
                        aws ecs run-task \
                        --cluster ${CLUSTER} \
                        --task-definition ${taskDefinition} \
                        --launch-type "FARGATE" \
                        --count 1 \
                        --network-configuration "awsvpcConfiguration={subnets=[${SUBNET_ID}],securityGroups=[${SECURITY_GROUP_ID}],assignPublicIp=ENABLED}" \
                        --overrides '{"containerOverrides":[{"name":"${CONTAINER_NAME}","command":["php","artisan","migrate","--force"]}]}' \
                        --region ${AWS_DEFAULT_REGION} \
                        --query "tasks[0].taskArn" \
                        --output text
                    """, returnStdout: true).trim()

                    sh """
                    echo "Waiting for migration task to complete..."
                    aws ecs wait tasks-stopped --cluster ${CLUSTER} --tasks ${taskArn} --region ${AWS_DEFAULT_REGION}
                    """
                }
            }
        }
    }
}