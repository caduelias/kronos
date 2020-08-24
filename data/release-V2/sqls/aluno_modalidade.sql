select 
    m.nome_modalidade, 
    count(soma.codigo_aluno) as qtde, 
    m.status 
from modalidade m
INNER join (
    select 
        DISTINCT(am.codigo_aluno), 
        am.codigo_modalidade 
    from aluno_modalidade am 
    GROUP by am.codigo_aluno, am.codigo_modalidade) soma on soma.codigo_modalidade = m.codigo_modalidade 
    WHERE (case when null is null then true else m.codigo_modalidade = 8 end) and
    (case when 'a' is null then true else m.status = 0 end)
GROUP by m.codigo_modalidade
order by m.nome_modalidade