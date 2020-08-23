select a.nome_aluno, count(a.codigo_aluno) as qtde from aluno a 
INNER join (
select DISTINCT(a.codigo_aluno) from avaliacao a WHERE a.data_avaliacao BETWEEN '2020-01-01' and '2020-12-12') alunos
on alunos.codigo_aluno = a.codigo_aluno
INNER join avaliacao av on av.codigo_aluno = a.codigo_aluno
WHERE av.imc BETWEEN 25.00 and 29.99 
and (case when null is null then true else av.idade BETWEEN 32 and 70 end)




select a.codigo_aluno, a.nome_aluno, COUNT(a.codigo_aluno) as total from aluno a 
INNER join (
select DISTINCT(a.codigo_aluno) from avaliacao a WHERE a.data_avaliacao BETWEEN '2020-01-01' and '2020-12-12') alunos
on alunos.codigo_aluno = a.codigo_aluno
INNER join avaliacao av on av.codigo_aluno = a.codigo_aluno
WHERE av.imc BETWEEN 23.00 and 50.99 
and (case when null is null then true else av.idade BETWEEN 32 and 70 end)
and (case when 'sexo' is null then true else a.sexo = 'F' end) 
GROUP by a.codigo_aluno
