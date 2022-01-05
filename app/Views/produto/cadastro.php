<div class="container">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <h3>Cadastro de Produto</h3>
            
            <?php if($Sessao::retornaErro()){ ?>
                <div class="alert alert-warning" role="alert">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <?php foreach($Sessao::retornaErro() as $key => $mensagem){ ?>
                        <?php echo $mensagem; ?> <br>
                    <?php } ?>
                </div>
            <?php } ?>

            <form action="http://<?php echo APP_HOST; ?>/produto/salvar" method="post" id="form_cadastro">
                <div class="form-group">
                    <label for="nome">Nome</label>
                    <input type="text" class="form-control"  name="nome" placeholder="Nome do Produto" value="<?php echo $Sessao::retornaValorFormulario('nome'); ?>" required>

                </div>
                <div class="form-group">
                    <label for="preco">Preço</label>
                    R$ <input type="text" class="form-control money" maxlength="11" name="preco" placeholder="100" value="<?php echo $Sessao::retornaValorFormulario('preco'); ?>" required>

                </div>
                <div class="form-group">
                    <label for="unidade">Unidade</label>
                    <select name="unidade" class="form-control">
                        <option value="Caixa" <?php echo ($Sessao::retornaValorFormulario('Caixa') == "Caixa") ? "select" : "" ?>>Caixa</option>
                        <option value="Pacote"  <?php echo ($Sessao::retornaValorFormulario('Pacote') == "Pacote") ? "select" : "" ?>>Pacote</option>
                        <option value="Unidade"  <?php echo ($Sessao::retornaValorFormulario('Unidade') == "Unidade") ? "select" : "" ?>>Unidade</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="ean">EAN</label>
                    <input type="text" class="form-control" name="ean" placeholder="0" value="<?php echo $Sessao::retornaValorFormulario('ean'); ?>" maxlength="13" required>

                </div>
                <div class="form-group">
                    <label for="statu_s">Ativo</label>
                    <input type="radio" class="form-check-input" id="status_s" name="status" value="S" checked>
                    <label for="status_n">Desativado</label>
                    <input type="radio" class="form-check-input" id="status_n" name="status" value="N">
                </div>
                <div class="form-group">
                    <label for="descricao">Descrição</label>
                    <textarea class="form-control" name="descricao" placeholder="Descrição do produto" required><?php echo $Sessao::retornaValorFormulario('descricao'); ?></textarea>

                </div>

                <button type="submit" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Salvar </button>
                <a href="http://<?php echo APP_HOST; ?>/produto" class="btn btn-info btn-sm"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Voltar</a>
            </form>
        </div>
        <div class=" col-md-3"></div>
    </div>
</div>