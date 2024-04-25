-- Avisos
SELECT x.categoria, x.imagen, x.color, x.id, x.titulo, x.resumen, DATE_FORMAT(x.fecha, '%d.%m.%Y') AS fecha
  FROM (SELECT notice_categories.categoria, notice_categories.imagen, notice_categories.color,
							 notices.id, notices.titulo, notices.resumen, notices.created_at AS fecha
					FROM notices
					LEFT JOIN notice_categories ON notice_categories.id=notices.categoria_id
				 WHERE notice_categories.estatus=1
					 AND notices.inicia IS NULL OR notices.termina IS NULL
				 UNION ALL
				SELECT notice_categories.categoria, notice_categories.imagen, notice_categories.color,
							 notices.id, notices.titulo, notices.resumen, notices.created_at AS fecha
					FROM notices
					LEFT JOIN notice_categories ON notice_categories.id=notices.categoria_id
				 WHERE notice_categories.estatus=1
					 AND CURDATE()>=notices.inicia
					 AND CURDATE()<=notices.termina) AS x
 ORDER BY x.id DESC


-- Enlaces
SELECT links.id, links.categoria_id, links.titulo, links.url, link_categories.categoria
  FROM links
	LEFT JOIN link_categories ON link_categories.id=links.categoria_id
 WHERE links.estatus=1
   AND link_categories.estatus=1
   AND link_categories.borrado=0
 ORDER BY link_categories.categoria ASC, links.titulo ASC


-- Cumpleaños
SELECT users.name AS nombre, DATE_FORMAT(profiles.nacimiento, '%d.%m') AS nacimiento, profiles.avatar, profiles.puesto, departments.departamento
  FROM profiles
	LEFT JOIN users ON profiles.user_id=users.id
	LEFT JOIN departments ON profiles.departamento_id=departments.id
 WHERE DATE_FORMAT(nacimiento, '%m-%d') BETWEEN DATE_FORMAT(DATE_SUB(CURRENT_DATE(), INTERVAL 15 DAY), '%m-%d') AND DATE_FORMAT(DATE_ADD(CURRENT_DATE(), INTERVAL 15 DAY), '%m-%d')
   AND profiles.id!=1
 ORDER BY MONTH(nacimiento) ASC, DAY(nacimiento) ASC