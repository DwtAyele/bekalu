SELECT pc.page_category_id, pc.category, pc.link, pc.icon, pc.prefix_html, pc.sefix_html,
    p.page, p.page_link, p.page_icon, p.page_prefix, p.page_sefix, p.category_id,
    ra.role_action_id, ra.action,
    ur.comment, ur.created_at, ur.updated_at, ur.expiry_date
FROM user_roles AS ur
    join role_actions AS ra ON  ur.role_action_id = ra.role_action_id
    join rolepage AS rp ON  ur.role_page_id = rp.rolepage_id
    join pages AS p ON  ur.role_page_id = p.page_id
    JOIN page_categories AS pc ON p.category_id = pc.page_category_id
    join users AS u ON  ur.user_id = u.user_id
where u.email= 'dwtk.ayele@gmail.com'
    AND ur.flag = 1
    AND p.flag = 1
    AND pc.flag = 1
    AND (ur.expiry_date >= CURRENT_DATE
() OR ur.expiry_date IS NULL)
GROUP BY p.page_id



SELECT MIN(r.role_priority), r.role
FROM roles as r
    JOIN rolepage AS rp ON r.role_id = rp.role_id
    JOIN user_roles AS ur ON rp.rolepage_id = ur.role_page_id
    JOIN users AS u ON ur.user_id = u.user_id
WHERE u.email = "dwtk.ayele@gmail.com";

SELECT *
FROM tags
WHERE   flag=1 OR usar_id=1




SELECT ROW_NUMBER() over ( order by w.word_id ASC) AS row_num, w.word_id, w.word, w.pronunciation, w.accessibility, m.meaning, m.example, m.homonyms, m.part_of_speech_id, m.meaning_image, m.created_at,
    u.firstname, u.lastname, u.email, u.image, d.full_name, d.short_name, word_meaning.word_meaning_id, num_like, num_dislike,
    sum(us.suggestion = 3) as FLAGE, ps.part_of_speech, ps.abbreviation
FROM word_meaning AS wm
    JOIN words as w ON wm.word_id = w.word_id
    JOIN meanings AS m ON wm.meaning_id = m.meaning_id
    JOIN users AS u ON wm.user_id = u.user_id
    JOIN dictionary AS d ON wm.dictionary_id = d.dictionary_id
    LEFT JOIN user_suggestions AS us ON wm.word_meaning_id = us.word_meaning_id
    LEFT JOIN parts_of_speechs AS ps ON m.part_of_speech_id = ps.part_of_speech_id



SELECT ROW_NUMBER() over ( order by w.word_id ASC) AS row_num, w.word_id, w.word, w.pronunciation, w.accessibility, m.meaning, m.example, m.homonyms, m.part_of_speech_id, m.meaning_image, m.created_at,
    u.firstname, u.lastname, u.email, u.image, d.full_name, d.short_name, word_meaning.word_meaning_id, num_like, num_dislike,
    sum(us.suggestion = 3) as FLAGE, ps.part_of_speech, ps.abbreviation, t.tag, t.abbreviation
FROM word_meaning AS wm
    JOIN words as w ON wm.word_id = w.word_id
    JOIN meanings AS m ON wm.meaning_id = m.meaning_id
    JOIN users AS u ON wm.user_id = u.user_id
    JOIN dictionary AS d ON wm.dictionary_id = d.dictionary_id
    LEFT JOIN user_suggestions AS us ON wm.word_meaning_id = us.word_meaning_id
    LEFT JOIN word_part_of_speech AS wps ON m.part_of_speech_id = wps.word_part_of_speech_id
    LEFT JOIN parts_of_speechs AS ps ON wps.part_of_speech_id = ps.part_of_speech_id
    LEFT JOIN word_meaning_tags AS wmt ON wm.word_meaning_id = wmt.word_meaning_id
    LEFT JOIN tags AS t ON wmt.tag_id = t.tag_id

SELECT word_meaning_id, SUM(suggestion='1') as LIKES, SUM(suggestion='2') AS DISLIKES, SUM(suggestion='3') AS FLAGE,
    user_id, comment, created_at, flag
FROM user_suggestions AS us
WHERE us.word_meaning_id = 1
GROUP BY us.word_meaning_id


SELECT t.tag, t.abbreviation, wmt.word_meaning_id
FROM word_meaning_tags AS wmt
    JOIN tags AS t ON wmt.tag_id = t.tag_id
WHERE wmt.word_meaning_id = 21
GROUP BY wmt.word_meaning_tag_id;


SELECT ROW_NUMBER() over ( order by w.word_id ASC) AS row_num, w.word_id, w.word, w.pronunciation, w.accessibility, m.meaning, m.example, m.homonyms, m.part_of_speech_id, m.meaning_image, m.created_at,
    u.firstname, u.lastname, u.email, u.image, d.full_name, d.short_name, wm.word_meaning_id, num_like, num_dislike,
    sum(us.suggestion = 3) as FLAGE, ps.part_of_speech, ps.abbreviation
FROM word_meaning AS wm
    JOIN words as w ON wm.word_id = w.word_id
    JOIN meanings AS m ON wm.meaning_id = m.meaning_id
    JOIN users AS u ON wm.user_id = u.user_id
    JOIN dictionary AS d ON wm.dictionary_id = d.dictionary_id
    LEFT JOIN user_suggestions AS us ON wm.word_meaning_id = us.word_meaning_id
    LEFT JOIN parts_of_speechs AS ps ON m.part_of_speech_id = ps.part_of_speech_id
    
WHERE w.word LIKE 'abc 2'
OR wm.word_meaning_id LIKE 19
GROUP BY wm.word_meaning_id


SELECT ROW_NUMBER() over ( order by w.word_id ASC) AS row_num, w.*, m.*, d.full_name, d.short_name, wm.*
FROM words AS w
    JOIN word_meaning as wm ON w.word_id = wm.word_id
    JOIN meanings AS m ON wm.meaning_id = m.meaning_id
    JOIN dictionary AS d ON wm.dictionary_id = d.dictionary_id    
WHERE w.word_id = 355


 
update words set word=trim(word);


SELECT ROW_NUMBER() over ( order by w.word_id ASC) AS row_num, w.word_id, w.word, w.pronunciation, w.accessibility, m.meaning, m.example, m.homonyms, m.part_of_speech_id, m.meaning_image, m.created_at,
    d.full_name, d.short_name, wm.word_meaning_id, wm.user_id, wm.page_no, wm.comment, wm.num_like, num_dislike,wm.user_report,
    dica.word_name, dica.word_abbrivation, ps.part_of_speech, ps.abbreviation, aww.alternative_word_id, aww2.main_word_id
FROM word_meaning AS wm
    JOIN words AS w ON wm.word_id = w.word_id
    JOIN meanings AS m ON wm.meaning_id = m.meaning_id 
    JOIN dictionary AS d ON wm.dictionary_id = d.dictionary_id 
    LEFT JOIN word_dic_abbrivation AS wda ON w.word_id = wda.word_id
    LEFT JOIN dictionary_abbrivation AS dica ON wda.dictionary_abbrivation_id = dica.dictionary_abbrivation_Id
    LEFT JOIN parts_of_speechs AS ps ON m.part_of_speech_id = ps.part_of_speech_id
    LEFT JOIN alternative_word_writings AS aww ON w.word_id = aww.main_word_id
    LEFT JOIN alternative_word_writings AS aww2 ON w.word_id = aww2.alternative_word_id
    
WHERE w.word LIKE 'ሀ' 
GROUP BY wm.word_meaning_id
ORDER BY w.word_id


SELECT COUNT(wm.word_meaning_id), wm.page_no FROM word_meaning AS wm 
JOIN words AS w ON wm.word_id = w.word_id 
JOIN meanings AS m ON wm.meaning_id = m.meaning_id 
JOIN dictionary AS d ON wm.dictionary_id = d.dictionary_id 
WHERE d.dictionary_id =4 
GROUP BY wm.page_no;



SELECT ROW_NUMBER() over(ORDER BY d.short_name) AS row_num, 
d.short_name, COUNT(DISTINCT(wm.word_meaning_id)) AS ትርጉሞች, COUNT(DISTINCT(wm.page_no)) AS ገጽ, d.flag 
FROM dictionary AS d 

JOIN word_meaning AS wm ON d.dictionary_id = wm.dictionary_id
JOIN words AS w ON wm.word_id = w.word_id 
JOIN meanings AS m ON wm.meaning_id = m.meaning_id  

WHERE d.flag <=10
GROUP BY d.dictionary_id
ORDER BY d.short_name;

UPDATE meanings AS m, word_meaning AS wm SET
alphabet_order= 'ለ'
WHERE wm.meaning_id= m.meaning_id 
AND wm.dictionary_id=1
AND wm.page_no >=5
AND wm.page_no <=54