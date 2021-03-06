<script>
    $scope.session = (new URL(window.location.href)).searchParams.get("session");
    $scope.sigle = (new URL(window.location.href)).searchParams.get("cours");
    $scope.model.tDocuments.forEach((x,i) => $scope.model.tDocuments[i] = new DocumentBD(x));
    $scope.backup = JSON.parse(JSON.stringify($scope.model.tDocuments));
    $scope.model.tDocuments.unshift(new DocumentBD({
        id: $scope.model.lastIndex,
        session: $scope.session,
        sigle: $scope.sigle
    }));
    $scope.model.tDocuments[0].modelState = 0;
    $scope.fichierAttrib = {
        noFichier: "{{doc.id}}"
    };
    $scope.trAttrib = {
        id: "tr_{{doc.id}}"
    };
    $scope.annuleAttrib = {
        onclick: "annuler('{{doc.id}}')"
    };
    $scope.noCatAttrib = {
        value: "{{cat.descrption}}"
    };
    $scope.docCatAttrib = {
        value: "{{doc.categorie}}"
    };
    configPost(DocumentBD,null,"$scope.model.tDocuments");

    $_anguleuxInterne.customEventListeners.push( function (e) {
        console.log(e.type);
        if((e.type === "keydown" || e.type === "change") && !e.$_init) {
            let parents = getAllParents(e.target);
            let nodeTr = parents.find(obj => obj.tagName === "TR");
            if (nodeTr && nodeTr.$_objRef[nodeTr.$_objIndex]) {
                if (nodeTr.$_objRef[nodeTr.$_objIndex].modelState === 2) {
                    //nodeTr.style.backgroundColor = '#8cff1a';
                    nodeTr.style.backgroundColor = '#ffff33';
                }
            }
        }
    });

    function annuler(id) {
        let aAnnuler = $scope.model.tDocuments.find(obj => obj.id === id);
        let aRetrouver = $scope.backup.find(obj => obj.id === id);
        if(aAnnuler){
            Object.assign(aAnnuler,aRetrouver);
            let trObj = document.getElementById("tr_" + id);
            trObj.style.backgroundColor = null;
            let event = new Event("change");
            event.$_init = true;
            Array.from(trObj.getElementsByTagName("input")).forEach(x => x.dispatchEvent(event));
        }
    }

    function removeFirst(){
        delete $_postObj.tabObjToPost[0];
    }

    function nouvObj() {
        let fileList = document.getElementById("tr_" + $scope.model.tDocuments[0].id).querySelector("[fileInput]").files;
        $scope.model.lastIndex++;
        $scope.model.tDocuments.unshift(new DocumentBD({
            id: $scope.model.lastIndex,
            session: $scope.session,
            sigle: $scope.sigle
        }));
        $scope.model.tDocuments[1].modelState = 0;
        $_anguleuxInterne.updateAgFor(document.getElementById("tr_parent"));
        configPost(DocumentBD,null,"$scope.model.tDocuments");
        document.getElementById("tr_" + $scope.model.tDocuments[1].id).style.backgroundColor = 'green';
        document.getElementById("tr_" + $scope.model.tDocuments[1].id).querySelector("[fileInput]").files = fileList;
        reconstruirePost($scope.model.tDocuments);
        reconstruireStyle($scope.model.tDocuments);
    }

    function postDocuments() {
        let tabFichiers = document.getElementsByName("fichierInput");
        let formData = new FormData();
        tabFichiers.forEach(input => {
            if(input.value !== ""){
                formData.append(input.getAttribute("noFichier"),input.files[0]);
            }
        });
        console.log(formData);
        if(!formData.values().next().done) {
            let xhr = new XMLHttpRequest();
            xhr.open('POST', '?controller=EditDocuments&action=SauvegardeFichier', true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    removeFirst();
                }
            };
            xhr.send(formData);
        }
    }
</script>

<link rel="stylesheet" href="Utilitaires/anguleux/AnguleuxStyle.css"/>
<link href="Views/EditDocuments/editDocumentsStyle.css" rel="stylesheet" type="text/css">
<div class="container">
    <div class="table-container">
        <table border="1" cellspacing="5" cellpadding="5">
            <tbody>
            <tr>
                <th>
                    <div class="checkbox">
                        <label>
                            <input name="checkbox" type="checkbox"
                                   onchange="document.querySelectorAll('[col1]').forEach(x => x.checked = event.target.checked)">
                            <em class="helper"></em>
                        </label>
                    </div>
                </th>
                <th scope="col">Date cours</th>
                <th scope="col">No Sequence</th>
                <th scope="col">Date acces debut</th>
                <th scope="col">Date acces fin</th>
                <th scope="col">Titre</th>
                <th scope="col">Description</th>
                <th scope="col">NbPages</th>
                <th scope="col">Categorie</th>
                <th scope="col">No version</th>
                <th scope="col">Date version</th>
                <th scope="col">Fichier</th>
                <th scope="col">Annuler</th>
            </tr>
            <tr ag-for="doc in model.tDocuments" attrib-bind-obj="trAttrib" id="tr_parent">
                <td>
                    <div class="checkbox">
                        <label>
                            <input name="checkbox" type="checkbox" col1 for-bind="true" for-bind-path="toDelete">
                            <em class="helper"></em>
                        </label>
                    </div>
                </td>
                <td><input type="date" name="date5" id="date13" for-bind="true" for-bind-path="dateCours"></td>
                <td><select name="select4" id="select10" for-bind="true" for-bind-path="noSequence">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                        <option>6</option>
                        <option>7</option>
                        <option>8</option>
                        <option>9</option>
                        <option>10</option>
                        <option>11</option>
                        <option>12</option>
                        <option>13</option>
                        <option>14</option>
                        <option>15</option>
                        <option>16</option>
                        <option>17</option>
                        <option>18</option>
                        <option>19</option>
                        <option>20</option>
                    </select>
                </td>
                <td><input type="date" name="date5" id="date14" for-bind="true" for-bind-path="dateAccesDebut"
                           min="2018-01-01" max="2021-12-31"></td>
                <td><input type="date" name="date5" id="date15" for-bind="true" for-bind-path="dateAccesFin"
                           min="2018-01-01" max="2021-12-31"></td>
                <td><input type="text" name="textfield3" id="textfield7" placeholder="Entrez un titre" for-bind="true"
                           for-bind-path="titre" minlength="5" maxlength="100"></td>
                <td><input type="text" name="textfield3" id="textfield8" placeholder="Entrez une description"
                           for-bind="true" for-bind-path="description" minlength="5" maxlength="255"></td>
                <td><input type="number" name="number2" id="number4" for-bind="true" for-bind-path="nbPages" min="1"
                           max="99"></td>
                <td>
                    <select attrib-bind-obj="docCatAttrib" for-bind="true" for-bind-path="categorie">
                        <?php
                            foreach ($model->tCategories as $cat) {
                                ?>
                                <option value="<?= $cat->description ?>"><?= $cat->description ?></option>
                            <?php } ?>
                    </select>
                </td>
                <td><select name="select4" id="select12" for-bind="true" for-bind-path="noVersion">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                    </select>
                </td>
                <td><input type="date" name="date5" id="date16" for-bind="true" for-bind-path="dateVersion"></td>
                <td>
                    <form method="post" action="?controller=EditDocuments&action=UploadDocuments"
                          onsubmit="return false" enctype="multipart/form-data">
                        <label for="fichierInput">Changer le document</label>
                        <input type="file" name="fichierInput" attrib-bind-obj="fichierAttrib" fileInput>
                    </form>
                </td>
                <td>
                    <button type="button" attrib-bind-obj="annuleAttrib">&nbsp;X&nbsp</button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>

    <button type="button" name="submit" id="submit" class="boutonsConfirm" onclick="postChanges('Document', 'module-admin.php?controller=BD&action=Confirmer', postDocuments)">
        Enregistrement
    </button>
    <button type="button" name="submit" id="submit" class="boutonsConfirm" onclick="nouvObj()">
        Ajouter
    </button>
    <button type="button" name="submit" id="submit" class="boutonsConfirm" onclick="deleteSelected($scope.model.tDocuments, 'id')">
        Supprimer
    </button>
    <button type="button" name="button" id="button" class="boutonsConfirm"
            onclick="window.location='?controller=AdminMenu&action=AdminMenu';">
        Retour
    </button>
</div>