import os
import requests
import subprocess
import mysql.connector
import mysql
import hashlib
import datetime
import pyudev
import json

downloadlink = ''
quar = ''

configdb_route = "../s4f3/db.json"
configapi_route = "../s4f3/api.txt"

with open(configdb_route, "r") as archivo:
    config = json.load(archivo)


def check_database(sha256, file_path):
    connection = mysql.connector.connect(**config)

    cursor = connection.cursor()
    query = "SELECT COUNT(*) FROM files WHERE sha256 = MD5(%s) AND file_path = direccion(%s)"
    values = (sha256, file_path)
    cursor.execute(query, values)
    result = cursor.fetchone()
    count = result[0]
    
    cursor.close()
    connection.close()

    return count > 0

#Para el sha
def get_sha256(file_path):
    sha256 = hashlib.sha256()
    with open(file_path, "rb") as f:
        while True:
            data = f.read(65536)
            if not data:
                break
            sha256.update(data)
    return sha256.hexdigest()

#Listar el directorio de media/tuusb
def list_files(directory):
    for root, _, files in os.walk(directory):
        for file in files:
            yield os.path.join(root, file)

def check_word_in_filenames(directory, word):
    for file in list_files(directory):
        if word in file:
            return True
    return False


# Conexión con MySQL
try:
    with open(configdb_route, "r") as archivo:
        config = json.load(archivo)

    # Establecer la conexión a MySQL
    connection = mysql.connector.connect(**config)
    comanda="lsblk -S | egrep 'usb' | cut -d' ' -f1 > tmp"
    os.system(comanda)
    
    for disp in open('tmp','r').readlines():
        disp=disp.rstrip('\n')
        print(f"Searching {disp}")
        comanda2=f"lsblk -o NAME,LABEL | egrep '{disp}1' | rev | cut -d ' ' -f1 | rev > tmp2"
        os.system(comanda2)
        label=open('tmp2','r').readline().rstrip('\n')
        print(f"Media named {label} founded!")
        os.system(f"mkdir /media/{label}")
        os.system(f"mount -t auto /dev/{disp}1 /media/{label}")
        try:
            os.system(f"mkdir ../../../asix-project/www/uploaded/{label}")
            os.system(f"mkdir ../../../asix-project/www/reports/{label}")
            os.system(f"mkdir ../../../asix-project/www/uploaded/{label}/pos")
            os.system(f"mkdir ../../../asix-project/www/uploaded/{label}/quar")
            print(f"Folders of {label} created successfully!")
        except FileExistsError:
            print(f"Folders of {label} already exists.")

        # Obtener lista de archivos en el dispositivo
        with open(configapi_route, "r") as archivo:
            api_key = archivo.read().strip()
        url = "https://www.virustotal.com/api/v3/files"
        headers = {
            "x-apikey": api_key,
            "accept": "application/json"
        }
        directory = f"/media/{label}"

        # Registros en las tablas de MySQL
        cursorr = connection.cursor()
        sql_select_query = """SELECT id_usb FROM usb ORDER BY id_usb DESC LIMIT 1"""
        cursorr.execute(sql_select_query)
        result = cursorr.fetchone()
        last_id = result[0]
        id_value = int(last_id) + 1
        date = datetime.datetime.now()
        sql_insert_query = """ INSERT INTO `usb`
                            (`id_usb`, `nombre`, `hora`) VALUES (%s, %s, %s) """
        insert_tuple = (id_value, label, date)
        result = cursorr.execute(sql_insert_query, insert_tuple)
        connection.commit()
        print(f"Record {label} inserted successfully into usb table")

        # Guardar el Log de ID de USB, y subirlo al apartado de Logs del servidor.
        plantilla =  " <------USB ID------> "
        log_file = open("../log/logusb.txt", "w")
        date = datetime.datetime.now()
        log_file.write("[" + date.strftime("%H") + ":" + date.strftime("%M") + ":" + date.strftime("%S")+ "] " + str(plantilla) + str(label))
        log_file.close()
        copylogfile=f"sudo cp '../log/logusb.txt' '../../../asix-project/www/logs/'"
        os.system(copylogfile)
        print(f"The usb log has been updated with the usb {label}")


        for file_path in list_files(directory):
            if "System Volume Information" in file_path:
                pass
            file_name = os.path.basename(file_path)
            file_size = os.path.getsize(file_path)
            print(f"The size of the file {file_name} is {file_size} bytes")
            sha256 = get_sha256(file_path)
            print(f"{sha256} is the SHA256 for this file")
            with open(file_path, "rb") as f:
                if file_size <= 32 * 1024 * 1024:
                # Archivo pequeño usando el request.post normal
                    response = requests.post(url, headers=headers, files={"file": f})
                else:
                # Archivo grande usando request por chunks
                    response = requests.post(url, headers=headers, data=f, stream=True)
                response.raise_for_status()
                json_response = response.json()
                file_id = json_response["data"]["id"]
                print(f"File {file_path} uploaded with ID {file_id}")
                # Obtener file report
                headersan = {"accept": "application/json",
                            "x-apikey": api_key}
                urlan = f"https://www.virustotal.com/api/v3/analyses/{file_id}"
                response = requests.get(urlan, headers=headersan)
                response.raise_for_status()
                #json_response = response.json()
                data = json.loads(response.content)
                analdump = json.dumps(data)
                
                
                analdir_path = "/home/raspy/app/def/reports/"

                # Define the name of the file
                anal_file = f"{file_name}.json"

                # Combine the directory path and file name
                analfile_path = os.path.join(analdir_path, anal_file)

                # Create a new text file in write mode in the specified directory
                with open(analfile_path, "w") as f:
                    # Write the value of the data_variable to the file
                    f.write(analdump)

                copyanal=f'sudo cp "{analfile_path}" "../../../asix-project/www/reports/{label}"'
                os.system(copyanal)
                print(f"The report file {anal_file} has been uploaded")
                analfileweb=f"/reports/{label}/{anal_file}"
            if response.status_code == 200:
                print(f"The analysis for the file {file_name} is completed \n")

            else: 
                print(f"The analysis for the file {file_name} is queued, please wait")
        
            files_removed = []  # Lista para realizar un seguimiento de los archivos eliminados

            for engine, result in data['data']['attributes']["results"].items():
                # Si el archivo es "malicious", a tomar por culo
                if result['category'] == "malicious":
                    categoria = engine + " - " + result["category"]
                    if 'quarentena' in file_path:
                        print(f"The file {file_name} has been detected as malicious, but it's in quarantine")
                        pass
                    else:
                        if file_path not in files_removed:  # Verificar si el archivo ya ha sido eliminado
                            os.remove(file_path)
                            files_removed.append(file_path)  # Agregar el archivo a la lista de eliminados
                            print(f"The file {file_name} has been detected as malicious, it has been removed from the usb")


                # Si el archivo no es "malicious", sube a quar si hay carpeta llamada "quarentena" y a pos los archivos sin virus.
                else:
                    if 'quarentena' in file_path:
                        quar = 1
                        route = f'../../../asix-project/www/uploaded/{label}/quar'
                        copyfiles = f'sudo cp -r "{file_path}" "{route}"'
                        os.system(copyfiles)
                        downloadlink = f'/uploaded/{label}/quar/' + file_name
                    else:
                        quar = 0
                        route = f'../../../asix-project/www/uploaded/{label}/pos'
                        copyfiles = f'sudo cp -r "{file_path}" "{route}"'
                        os.system(copyfiles)
                        downloadlink = f'/uploaded/{label}/pos/' + file_name
                        
            print(f"The file {file_name} stats are: {data['data']['attributes']['stats']}")
         
            
            # Guardar el Log de archivos, con su Hash y ruta originales y subirlo al apartado de Logs del servidor
            plantilla =  " <------FILE HASH & ROUTE------> "
            log_file = open("../log/logfile.txt", "w")
            date = datetime.datetime.now()
            log_file.write("[" + date.strftime("%H") + ":" + date.strftime("%M") + ":" + date.strftime("%S")+ "] " + str(plantilla) + sha256 + ' ' + file_path + "\n" )
            log_file.close()
            copylogfile=f"sudo cp '../log/logfile.txt' '../../../asix-project/www/logs/'"
            os.system(copylogfile)
            print(f"The file log has been uploaded with the file {file_name}")

            status = (int(quar))

            sql_select_query = """SELECT id FROM archivos ORDER BY id DESC LIMIT 1"""
            cursorr = connection.cursor()
            cursorr.execute(sql_select_query)
            result = cursorr.fetchone()
            last_fileid = result[0]
            id_file = int(last_fileid) + 1
            sql_insert_query = """ INSERT INTO `archivos`
                                (`id`, `nombre`, `ubicacion`, `direccion`, `MD5`, `usb`, `report`, `estado`) VALUES (%s, %s, %s, %s, %s, %s, %s, %s) """
            insert_tuple = (id_file, file_name, file_path, downloadlink, sha256, id_value, analfileweb, status)
            result = cursorr.execute(sql_insert_query, insert_tuple)
            connection.commit()
            print(f"Record {file_name} inserted successfully into archivos table" + "\n")


except mysql.connector.Error as e:
    print("Error while connecting to MySQL", e)
finally:
    if (connection.is_connected()):
        cursorr.close()
        connection.close()
        print("MySQL connection is closed")