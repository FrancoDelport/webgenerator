echo "Iniciando"
echo "Nombre de la carpeta" $1
		mkdir $1
		zip -r $1.zip $1
echo "Finalizado"