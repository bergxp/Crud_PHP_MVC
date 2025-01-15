<?php
class Comentario
{
    public static function selecionarComentarios($idPost)
    {
        $con = Connection::getConn();
        $sql = "SELECT * FROM comentario WHERE id_postagem = :id";
        $sql = $con->prepare($sql);
        $sql->bindValue(":id", $idPost, PDO::PARAM_INT);
        $sql->execute();

        $resultado = array();
        while ($row = $sql->fetchObject("comentario")) {
            $resultado[] = $row;
        }

        return $resultado;
    }
    public static function inserir($reqPost){
        $con = Connection::getConn();
        $sql = "INSERT INTO comentario (nome,mensagem, id_postagem) VALUES (:nome, :msg, :idp)";
        $sql = $con->prepare($sql);
        $sql->bindValue(":idp", $reqPost['id']);
        $sql->bindValue(":msg", $reqPost['msg']);
        $sql->bindValue(":nome", $reqPost['nome']);
        
        $sql->execute();

if($sql->rowCount()){
    return true;
}
throw new Exception("Falha na inserção");

    }
    public static function remover($idPost){
        $con = Connection::getConn();
        $sql = "DELETE FROM comentario WHERE id = :id";
        $sql = $con->prepare($sql);
        $sql->bindValue(":id",$idPost['id']);
        $res = $sql->execute();
        
        if($res == 0){
            throw new Exception("Falha ao deletar comentario!");
            return false;
        }
        return true;
    
    }
}
