<body>
<?php var_dump($model) ?>
<div id="sCreerAdmin">
    <form id="frmCreerAdmin" method="post" action="index.php?controller=Login&action=CreerAdmin">
        <label for="tbNomUtilisateur">Nom D'Utilisateur</label>
        <input id="tbNomUtilisateur" name="tbNomUtilisateurAdmin" type="text"/><br/>
        <label for="tbNomComplet">Nom Complet</label>
        <input id="tbNomComplet" name="tbNomCompletAdmin" type="text"/><br/>
        <label for="tbCourriel">Courriel</label>
        <input id="tbCourriel" name="tbCourrielAdmin" type="text"/><br/>
        <label for="tbMotDePasse">Mot de passe</label>
        <input id="tbMotDePasse" name="tbMotDePasseAdmin" type="password"/><br/>
        <input id="btnSoumettre" name="btnSoumettre" type="submit" value="Creer"/>
    </form>
</div>
</body>