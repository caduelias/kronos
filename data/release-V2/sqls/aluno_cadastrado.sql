select 
    a.*, count(a.codigo_aluno) as quantidade 
from aluno a 
where a.data_cadastro BETWEEN '2020-01-01' and '2020-08-14'
and (case when 'sexo' is null then true else a.sexo = 'M' end) 
and (case when 'status' is null then true else a.status = '1' end)
order by a.nome_aluno;