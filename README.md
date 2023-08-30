# BOT ZECA FEIRA
aprendendo um pouco mais sobre o uso da API do twitter, criei um bot em que ele posta uma imagem do zeca pagodinho em uma quarta feira avisando que o dia é "zeca feira!"

# dependências
- é necessário ter o PHP na versão 8.1 (ou superior) para ser possível instalar as dependências
- é necessário ter o composer (na versão 2) instalado
# como rodar na minha máquina?
simples, o primeiro passo é rodar o comando
```
composer install
```
e após isso renomear o arquivo *.env.example para .env* e adicionar as suas credenciais geradas no seu app do twitter
e por último ele irá publicar uma foto do zeca-feira no seu bot, basta personalizar o texto e a imagem no arquivo Twitter.php

# um pouco sobre o projeto
- o arquivo index.php chama a classe Twitter e o método postTweet, que realiza todo o processo de upload de imagem e de postar o tweet
- há uma validação simples checando se o dia da semana é quarta, já que esse processo é rodado diariamente em um crontab, e nessa checagem ele verifica se o dia da semana é quarta-feira