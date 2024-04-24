SELECT links.id, links.categoria_id, links.titulo, links.url, link_categories.categoria
  FROM links
	LEFT JOIN link_categories ON link_categories.id=links.categoria_id
 WHERE links.estatus=1
   AND link_categories.estatus=1
   AND link_categories.borrado=0
 ORDER BY link_categories.categoria ASC, links.titulo ASC