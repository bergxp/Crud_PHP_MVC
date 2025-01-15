<?php

class Postagem
{
    public static function selecionaTodos()
    {

        $con = Connection::getConn();
        $sql = "SELECT * FROM postagem ORDER BY id DESC";
        $sql = $con->prepare($sql);
        $sql->execute();

        $resultado = array();

        while ($row = $sql->fetchObject('Postagem')) {
            $resultado[] = $row;
        }
        if (!$resultado) {
            throw new Exception("Não foi possivel encontar nenhum registro no banco");
        }
        return $resultado;
    }
    public static function selecionarPorId($idPost)
    {
        $con = Connection::getConn();
        $sql = "SELECT * FROM postagem WHERE id=:id";
        $sql = $con->prepare($sql);
        $sql->bindValue(":id", $idPost, PDO::PARAM_INT);
        $sql->execute();

        $resultado = $sql->fetchObject('Postagem');
        if (!$resultado) {
            throw new Exception("Não foi encontrado nenhum registro no banco de dados");
        } else {
            $resultado->comentarios = Comentario::selecionarComentarios($resultado->id);
        }
        return $resultado;
    }
    public static function insert($dadosPost)
    {
        if (empty($dadosPost['titulo']) or empty($dadosPost['conteudo'])) {
            throw new Exception("Preencha todos os campos !");
            return false;
        }
        $con = Connection::getConn();
        $sql = "INSERT INTO postagem (titulo, conteudo) VALUES (:tit, :cont)";
        $sql = $con->prepare($sql);
        $sql->bindValue(':tit', $dadosPost['titulo']);
        $sql->bindValue(':cont', $dadosPost['conteudo']);
        $res = $sql->execute();
        if ($res = 0) {
            throw new Exception("Falha ao inserir publicação");
            return false;
        }
        return true;
    }
    public static function delete($dadosPost){

            $con = Connection::getConn();
            $sql = "DELETE FROM postagem WHERE id = :id";
        
        $sql = $con->prepare($sql);
        $sql->bindValue(':id', $dadosPost['id'], PDO::PARAM_INT);
        $res = $sql->execute();
        if ($res == 0) {
            throw new Exception("Falha ao deletar publicação");
            return false;
        
        return true;
        }

    }

    public static function update($params){
        // if(isset($dadosPost['id'])){
            $con = Connection::getConn();
            $sql = "UPDATE postagem SET titulo = :tit, conteudo = :cont WHERE id = :id";

            $sql = $con->prepare($sql);
            $sql->bindValue(':id', $params['id']);
            $sql->bindValue(':tit', $params['titulo']);
            $sql->bindValue(':cont', $params['conteudo']);
            $res = $sql->execute();

            if($res ==0){
                throw new Exception("Falha ao alterar publicação");
            }
            return true;
        // }
    }
}
