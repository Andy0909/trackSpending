pipeline {
  agent any
  
  stages {
    stage('Cleanup') {
      steps {
        echo 'clean dir'
        sh 'rm -f *'
      }
    }
    
    stage('Zip') {
      steps {
        echo 'zip project'
        sh 'zip -r trackspending.zip'
      }
    }
    
    // 其他階段和步驟可以在此添加
  }
}
