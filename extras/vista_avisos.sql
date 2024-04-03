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