<?php

use Model\Produto;

class ProdutoRepositorio
{
    private PDO $pdo;

    /**
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function formarObjeto($dados)
    {
        return new Produto(
                $dados['id'],
                $dados['tipo'],
                $dados['nome'],
                $dados['descricao'],
                $dados['preco'],
                $dados['imagem']
        );
    }

    public function todosProdutos(): array
    {
        $sqlProdutos = "SELECT * FROM produtos ORDER BY preco";
        $stmt = $this->pdo->query($sqlProdutos);
        $todosProdutos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $dadosProdutos = array_map(function ($produto){
            return $this->formarObjeto($produto);
        }, $todosProdutos);
        return $dadosProdutos;

    }

    public function opcoesCafe(): array
    {
        $sqlCafe = "SELECT * FROM produtos WHERE tipo = 'Café' ORDER BY preco;";
        $stmt = $this->pdo->query($sqlCafe);
        $produtosCafe = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $dadosCafe = array_map(function($cafe){
            return $this->formarObjeto($cafe);
        }, $produtosCafe);

        return $dadosCafe;
    }

    public function opcoesAlmoco(): array
    {
        $sqlAlmoco = "SELECT * FROM produtos WHERE tipo = 'almoço' ORDER BY preco;";
        $stmt = $this->pdo->query($sqlAlmoco);
        $produtosAlmoco = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $dadosAlmoco = array_map(function($almoco){
            return $this->formarObjeto($almoco);
        }, $produtosAlmoco);

        return $dadosAlmoco;
    }

    public function deletar (int $id)
    {
        $sql = "DELETE FROM produtos WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
    }

    public function salvar(Produto $produto)
    {
        $query = "INSERT INTO produtos (tipo, nome, descricao, preco, imagem) VALUES (?,?,?,?,?)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(1, $produto->getTipo());
        $stmt->bindValue(2, $produto->getNome());
        $stmt->bindValue(3, $produto->getDescricao());
        $stmt->bindValue(4, $produto->getPreco());
        $stmt->bindValue(5, $produto->getImagem());
        $stmt->execute();
    }

}