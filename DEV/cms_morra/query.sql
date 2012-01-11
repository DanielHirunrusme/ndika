SELECT PagesDetail.*, Atribut.name
FROM `cms_pages_details` PagesDetail, cms_atributs Atribut, cms_pages Page
WHERE PagesDetail.page_id=Page.id AND PagesDetail.atribut_id=Atribut.id

--Mengambil semua Atribut yang belum ada di page_id tertentu
SELECT Atribut.id, Atribut.name 
FROM cms_atributs Atribut
WHERE
    Atribut.id NOT IN (SELECT atribut_id FROM cms_pages_details a WHERE a.page_id=1)
    
