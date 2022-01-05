<div class="container">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">

            <h3>Editar Produto</h3>

            <?php if($Sessao::retornaErro()){ ?>
                <div class="alert alert-warning" role="alert">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <?php foreach($Sessao::retornaErro() as $key => $mensagem){ ?>
                        <?php echo $mensagem; ?> <br>
                    <?php } ?>
                </div>
            <?php } ?>

            <form action="http://<?php echo APP_HOST; ?>/produto/atualizar/<?php echo $viewVar['queryString']; ?>" method="post" id="form_cadastro">
                <input type="hidden" class="form-control" name="id" id="id" value="<?php echo $viewVar['produto']->getId(); ?>">

                <div class="form-group">
                    <label for="nome">Nome</label>
                    <input type="text"  class="form-control" name="nome" id="nome" placeholder="" value="<?php echo $viewVar['produto']->getNome(); ?>" required>
                </div>

                <div class="form-group">
                    <label for="preco">Preço</label>
                    <input type="text"  class="form-control money" maxlength="11"  name="preco" id="preco" placeholder="" value="<?php echo App\Lib\ConversorMonetario::dolarParaReal($viewVar['produto']->getPreco()); ?>" required>
                </div>
                <div class="form-group">
                    <label for="unidade">Unidade</label>
                    <select name="unidade" class="form-control">
                        <option value="Caixa" <?php echo ($viewVar['produto']->getUnidade() == "Caixa") ? "select" : "" ?>>Caixa</option>
                        <option value="Pacote"  <?php echo ($viewVar['produto']->getUnidade() == "Pacote") ? "select" : "" ?>>Pacote</option>
                        <option value="Unidade"  <?php echo ($viewVar['produto']->getUnidade() == "Unidade") ? "select" : "" ?>>Unidade</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="ean">EAN</label>
                    <input type="text"  class="form-control"  name="ean" id="ean" placeholder="" value="<?php echo $viewVar['produto']->getEan(); ?>" maxlength="13"  required>
                </div>
                <div class="form-group">
                    <label for="status_s">Ativo</label>
                    <input type="radio" class="form-check-input" name="status" id="status_s" value="S" <?php echo ($viewVar['produto']->getStatus() == 'S') ? "checked" : "" ?>>
                    <label for="status_n">Desativado</label>
                    <input type="radio" class="form-check-input" name="status" id="status_n" value="N" <?php echo ($viewVar['produto']->getStatus() == 'N') ? "checked" : "" ?>>
                </div>


                <div class="form-group">
                    <label for="descricao">Descrição</label>
                    <textarea class="form-control" name="descricao" placeholder="Descrição do produto" required><?php echo $viewVar['produto']->getDescricao(); ?></textarea>
                </div>

                <button type="submit" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Salvar </button>
                <a href="http://<?php echo APP_HOST; ?>/produto/<?php echo $viewVar['queryString']; ?>" class="btn btn-info btn-sm"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Voltar</a>
            </form>
        </div>
        <div class=" col-md-3"></div>
    </div>
</div>
