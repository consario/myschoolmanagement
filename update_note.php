<?php
require_once 'database.php';
if(isset($_GET['etuid']) && !empty($_GET['etuid'])){
    if(isset($_POST) && !empty($_POST)){
        foreach($_POST as $matiere => $moyenne){
            if(!empty($moyenne)){
                $moy_uni_req = $pdo -> prepare('SELECT * FROM notes WHERE id_etu = :id AND matiere = :matiere');
                $moy_uni_req -> execute([
                    'id' => $_GET['etuid'],
                    'matiere' => $matiere
                    ]);

                $moy_uni_req_ans = $moy_uni_req -> fetchAll(PDO::FETCH_ASSOC);
                if(empty($moy_uni_req_ans)){
                    $note_insert = $pdo -> prepare('INSERT INTO notes(note,matiere,id_etu) VALUES(:note,:matiere,:id_etu)');
                    $ans = $note_insert -> execute([
                        'note' => $moyenne,
                        'matiere' => $matiere,
                        'id_etu' => $_GET['etuid']
                    ]);
                }
            }
            
        }    
    } 
}

header('Location:add_etu.php?etuid='.$_GET['etuid']);