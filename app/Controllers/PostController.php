<?php
class PostController
{
    public function index($params)
    {
        try {
            $postagem = Postagem::selecionarPorId($params);
            

            $loader = new \Twig\Loader\FilesystemLoader('app/View');
            $twig = new \Twig\Environment($loader);
            $template = $twig->load('single.html');

            $parametros = array();
            $parametros['id'] = $postagem->id;
            $parametros['titulo'] = $postagem->titulo;
            $parametros['conteudo'] = $postagem->conteudo;
            $parametros['comentarios'] = $postagem->comentarios;

          $conteudo = $template->render($parametros);
          echo $conteudo;
  
           
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public function addComent(){
        try{
            
            Comentario::inserir($_POST);
            echo '<script>alert("Publicação alterada com sucesso!");</script>';
            echo '<script>location.href="http://localhost:3000/?pagina=post&id='.$_POST['id'].'";  </script>';
        }catch(Exception $e){
            echo '<script>alert("' . $e->getMessage() . '");</script>';
            echo '<script>location.href="http://localhost:3000/?pagina=post&id='.$_POST['id'].'"; </script>';
        }
        
    }
    public function removeComent(){
        try{
            Comentario::remover($_POST);
                        echo '<script>alert("Comentario deletado com sucesso!");</script>';
            echo '<script>location.href="http://localhost:3000/?pagina=post&id='.$_POST['id'].'";  </script>';

        }catch(Exception $e){
            echo '<script>alert("' . $e->getMessage() . '");</script>';
            echo '<script>location.href="http://localhost:3000/?pagina=post&id='.$_POST['id'].'"; </script>';

        }

    }
}
