Para acessar o sistema com privilégios de gerente:<br>
Usuario: VISITANTE_ADMIN<br>
Senha: visitante_admin<br>
E para acessar o sistema com privilégios de funcionário:<br>
Usuario: VISITANTE_VISITANTE<br>
Senha: visitante_visitante<br>
Use o arquivo tapecaria.sql da pasta BANCO DE DADOS para popular o banco de dados e poder fazer os testes necessários do sistema.<br>
Criar uma base de dados de nome tapecaria, sem "Ç" antes de importar o SQL.<br>
Neste Sistema, o banco de dados se auto regula, conforme são adcionados e/ou removidos produtos, o Sistema faz o cálculo da média dos produtos de acordo com os valores lançados na hora do cadastro dos produtos, mesmo que em diferentes dias semanas meses e anos, retornando o preço médio para evitar perdas e prejuizos.<br>
Para tanto foram criadas trigger's e Procedures para a atualização automática das tabelas do banco de dados.
