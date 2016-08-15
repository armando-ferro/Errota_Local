import subprocess, threading
from email.mime.text import MIMEText
from email.mime.application import MIMEApplication
from email.mime.multipart import MIMEMultipart
from smtplib import SMTP
import smtplib
import sys
import MySQLdb
from mysql.connector import (connection)
from array import array

username = "root";
password = "Inactive90";
hostname = "localhost";
dbname = "mydb";

#Funcion para enviar correo al alumno

def envia_correo(to_addr_list, subject, dni, login, password,smtpserver):

	emaillist = to_addr_list
	msg = MIMEMultipart()
	msg['Subject'] = subject
	msg['From'] = 'igoraresti@gmail.com'
	msg['Reply-to'] = 'non-reply'
	 
	msg.preamble = 'Multipart massage.\n'

	part = MIMEApplication(open(dni,"rb").read())
	part.add_header('Content-Disposition', 'attachment', filename=dni+".txt")
	msg.attach(part)
	 

	server = smtplib.SMTP(smtpserver)
	server.ehlo()
	server.starttls()
	server.login(login, password)
	 
	server.sendmail(msg['From'], emaillist , msg.as_string())


# funciones para escribir el resultado de la practica 1 en caso de error

def escribe_fichero(dni_alumno, msg):
    with open(dni_alumno, 'a') as f:
        f.write(msg)

def crea_fichero_error_clone(dni_alumno):
    cmd = "cp clon-error dni_alumno"
    subprocess.call(cmd, shell = True)

# Clase para clonar los repositorios del alumno. Se lanza un proceso con un timeout que expirara en caso de que el repositorio no exista y asi no bloquear la ejecucin del test.

class Clonar(object):
    def __init__(self, cmd):
        self.cmd = cmd
        self.process = None

    def run(self, timeout):
        def target():
            print 'Empieza a clonar'
            self.process = subprocess.Popen(self.cmd, shell=True)
            self.process.communicate()
            print 'Termina de clonar'

        thread = threading.Thread(target=target)
        thread.start()

        thread.join(timeout)
        if thread.is_alive():
            print 'Clonacion no efectuada'
            self.process.terminate()
            thread.join()
        return self.process.returncode


#Test ejercicio ex00: ft_celsius_2_fahrenheit

def test_ex00(dni_alumno):
    cmd = "gcc P1/ex00/ft_celsius_2_fahrenheit.c testC/test0.c -o programa"
    subprocess.call(cmd, shell = True)
    cmd = "./programa "+dni_alumno
    nota = subprocess.call(cmd, shell = True)
    cmd = "rm programa"
    subprocess.call(cmd, shell = True)
    if nota == 127:
        nota = 0
        escribe_fichero(dni_alumno, "********************************************\nTEST EJERCICIO 00 - FT_CELSIUS_2_FARENHEIT\n********************************************\nERROR: IMPOSIBLE EJECUTAR O COMPILAR\n");
        print "Test 00: imposible ejecutar o compilar"
    else:
        print "Test 00 ejecutado con nota: ", nota
    return nota

#Test ejercicio ex01: ft_rev_num

def test_ex01(dni_alumno):
    cmd = "gcc P1/ex01/ft_rev_num.c testC/test1.c -o programa"
    subprocess.call(cmd, shell = True)
    cmd = "./programa "+dni_alumno
    nota = subprocess.call(cmd, shell = True)
    cmd = "rm programa"
    subprocess.call(cmd, shell = True)
    if nota == 127:
        nota = 0
        escribe_fichero(dni_alumno, "********************************************\nTEST EJERCICIO 01 - FT_REV_NUM\n********************************************\nERROR: IMPOSIBLE EJECUTAR O COMPILAR\n");
        print "Test 01: imposible ejecutar o compilar"
    else:
        print "Test 01 ejecutado con nota: ", nota
    return nota

#Test ejercicio ex02: ft_print_alphabet

def test_ex02(dni_alumno):
    cmd = "gcc P1/ex02/ft_print_alphabet.c testC/test2.c -o programa"
    subprocess.call(cmd, shell = True)
    cmd = "./programa"
    pipe = subprocess.Popen(cmd, shell = True, stdout=subprocess.PIPE, stderr=subprocess.PIPE)
    out, err = pipe.communicate()
    if err == "":
        if out == "abcdefghijklmnopqrstuvwxyz":
            print "Test 02 ejecutado con nota: 3"
            escribe_fichero(dni_alumno, "********************************************\nTEST EJERCICIO 02 - FT_PRINT_ALPHABET\n********************************************\nCOMPROBANDO QUE LA SALIDA ES: 'abcdefghijklmnopqrstuvwxyz'\n********************************************\nTEST SUPERADO\n");
            return 3
        else:
            print "Test 02 ejecutado con nota: 0"
            escribe_fichero(dni_alumno, "********************************************\nTEST EJERCICIO 02 - FT_PRINT_ALPHABET\n********************************************\nCOMPROBANDO QUE LA SALIDA ES: 'abcdefghijklmnopqrstuvwxyz'\n********************************************\nTEST NO SUPERADO\n");
    else:
        print "Test 02: imposible ejecutar o compilar"
        escribe_fichero(dni_alumno, "********************************************\nTEST EJERCICIO 02 - FT_PRINT_ALPHABET\n********************************************\nERROR: IMPOSIBLE EJECUTAR O COMPILAR\n");
 
    return 0
#Test ejercicio ex03: ft_IS_NEGATIVE

def test_ex03(dni_alumno):
    nota = 0
    cmd = "gcc P1/ex03/ft_is_negative.c testC/test3.c -o programa"
    subprocess.call(cmd, shell = True)
    cmd = "./programa "+dni_alumno+" '1'"
    pipe = subprocess.Popen(cmd, shell = True, stdout=subprocess.PIPE, stderr=subprocess.PIPE)
    out, err = pipe.communicate()
    if err == "":
        if out == "P":
            escribe_fichero(dni_alumno, "********************************************\nOK\n********************************************\n");
            nota = nota + 1
        else:
            escribe_fichero(dni_alumno, "********************************************\nTEST NO SUPERADO\n********************************************\n");

        cmd = "./programa "+dni_alumno+" '2'"
        pipe = subprocess.Popen(cmd, shell = True, stdout=subprocess.PIPE, stderr=subprocess.PIPE)
        out, err = pipe.communicate()
        if out == "N":
            escribe_fichero(dni_alumno, "********************************************\nOK\n********************************************\n");
            nota = nota + 1
        else:
            escribe_fichero(dni_alumno, "********************************************\nTEST NO SUPERADO\n********************************************\n");

        cmd = "./programa "+dni_alumno+" '3'"
        pipe = subprocess.Popen(cmd, shell = True, stdout=subprocess.PIPE, stderr=subprocess.PIPE)
        out, err = pipe.communicate()
        if out == "":
            escribe_fichero(dni_alumno, "********************************************\nOK\n********************************************\n");
            nota = nota + 1
        else:
            escribe_fichero(dni_alumno, "********************************************\nTEST NO SUPERADO\n********************************************\n");
        print "Test 03 ejecutado con nota: "+str(nota)
    else:
        print "Test 03: imposible ejecutar o compilar"
        escribe_fichero(dni_alumno, "********************************************\nTEST EJERCICIO 03 - FT_IS_NEGATIVE\n********************************************\nERROR: IMPOSIBLE EJECUTAR O COMPILAR\n");
    
            
    return nota

#Test ejercicio ex04: FT_PRINT_COMB

def test_ex04(dni_alumno):
    cmd = "gcc P1/ex04/ft_print_comb.c testC/test4.c -o programa"
    subprocess.call(cmd, shell = True)
    cmd = "./programa"
    pipe = subprocess.Popen(cmd, shell = True, stdout=subprocess.PIPE, stderr=subprocess.PIPE)
    out, err = pipe.communicate()
    if err == "":
        if out == "012, 013, 014, 015, 016, 017, 018, 019, 023, 024, 025, 026, 027, 028, 029, 034, 035, 036, 037, 038, 039, 045, 046, 047, 048, 049, 056, 057, 058, 059, 067, 068, 069, 078, 079, 089, 123, 124, 125, 126, 127, 128, 129, 134, 135, 136, 137, 138, 139, 145, 146, 147, 148, 149, 156, 157, 158, 159, 167, 168, 169, 178, 179, 189, 234, 235, 236, 237, 238, 239, 245, 246, 247, 248, 249, 256, 257, 258, 259, 267, 268, 269, 278, 279, 289, 345, 346, 347, 348, 349, 356, 357, 358, 359, 367, 368, 369, 378, 379, 389, 456, 457, 458, 459, 467, 468, 469, 478, 479, 489, 567, 568, 569, 578, 579, 589, 678, 679, 689, 789":
            print "Test 04 ejecutado con nota: 3"
            escribe_fichero(dni_alumno, "********************************************\nTEST EJERCICIO 04 - FT_PRINT_COMB\n********************************************\nCOMPROBANDO QUE LA SALIDA ES CORRECTA...\n********************************************\nTEST SUPERADO\n");
            return 3
        else:
            print "Test 04 ejecutado con nota: 0"
            escribe_fichero(dni_alumno, "********************************************\nTEST EJERCICIO 04 - FT_PRINT_COMB\n********************************************\nCOMPROBANDO QUE LA SALIDA ES CORRECTA...\n********************************************\nTEST NO SUPERADO\n");
    else:
        print "Test 04: imposible ejecutar o compilar"
        escribe_fichero(dni_alumno, "********************************************\nTEST EJERCICIO 04 - FT_PRINT_COMB\n********************************************\nERROR: IMPOSIBLE EJECUTAR O COMPILAR\n");
 
    return 0

#Test ejercicio ex05: FT_PRINT_LARGEST

def test_ex05(dni_alumno):
    nota = 0
    cmd = "gcc P1/ex05/ft_print_largest.c testC/test5.c -o programa"
    subprocess.call(cmd, shell = True)
    cmd = "./programa "+dni_alumno+" '1'"
    pipe = subprocess.Popen(cmd, shell = True, stdout=subprocess.PIPE, stderr=subprocess.PIPE)
    out, err = pipe.communicate()
    if err == "":
        if out == "9":
            escribe_fichero(dni_alumno, "********************************************\nOK\n********************************************\n");
            nota = nota + 1
        else:
            escribe_fichero(dni_alumno, "********************************************\nTEST NO SUPERADO\n********************************************\n");

        cmd = "./programa "+dni_alumno+" '2'"
        pipe = subprocess.Popen(cmd, shell = True, stdout=subprocess.PIPE, stderr=subprocess.PIPE)
        out, err = pipe.communicate()
        if out == "5":
            escribe_fichero(dni_alumno, "********************************************\nOK\n********************************************\n");
            nota = nota + 1
        else:
            escribe_fichero(dni_alumno, "********************************************\nTEST NO SUPERADO\n********************************************\n");

        cmd = "./programa "+dni_alumno+" '3'"
        pipe = subprocess.Popen(cmd, shell = True, stdout=subprocess.PIPE, stderr=subprocess.PIPE)
        out, err = pipe.communicate()
        if out == "8":
            escribe_fichero(dni_alumno, "********************************************\nOK\n********************************************\n");
            nota = nota + 1
        else:
            escribe_fichero(dni_alumno, "********************************************\nTEST NO SUPERADO\n********************************************\n");
        print "Test 05 ejecutado con nota: "+str(nota)
    else:
        print "Test 05: imposible ejecutar o compilar"
        escribe_fichero(dni_alumno, "********************************************\nTEST EJERCICIO 05 - FT_PRINT_LARGEST\n********************************************\nERROR: IMPOSIBLE EJECUTAR O COMPILAR\n");
    
            
    return nota

#Test ejercicio ex06: ft_putnbr

def test_ex06(dni_alumno):
    nota = 0
    cmd = "gcc P1/ex06/ft_putnbr.c testC/test6.c -o programa"
    subprocess.call(cmd, shell = True)
    cmd = "./programa "+dni_alumno+" '1'"
    pipe = subprocess.Popen(cmd, shell = True, stdout=subprocess.PIPE, stderr=subprocess.PIPE)
    out, err = pipe.communicate()
    if err == "":
        if out == "123":
            escribe_fichero(dni_alumno, "********************************************\nOK\n********************************************\n");
            nota = nota + 1
        else:
            escribe_fichero(dni_alumno, "********************************************\nTEST NO SUPERADO\n********************************************\n");

        cmd = "./programa "+dni_alumno+" '2'"
        pipe = subprocess.Popen(cmd, shell = True, stdout=subprocess.PIPE, stderr=subprocess.PIPE)
        out, err = pipe.communicate()
        if out == "-123":
            escribe_fichero(dni_alumno, "********************************************\nOK\n********************************************\n");
            nota = nota + 1
        else:
            escribe_fichero(dni_alumno, "********************************************\nTEST NO SUPERADO\n********************************************\n");

        cmd = "./programa "+dni_alumno+" '3'"
        pipe = subprocess.Popen(cmd, shell = True, stdout=subprocess.PIPE, stderr=subprocess.PIPE)
        out, err = pipe.communicate()
        if out == "0":
            escribe_fichero(dni_alumno, "********************************************\nOK\n********************************************\n");
            nota = nota + 1
        else:
            escribe_fichero(dni_alumno, "********************************************\nTEST NO SUPERADO\n********************************************\n");
        print "Test 06 ejecutado con nota: "+str(nota)
    else:
        print "Test 06: imposible ejecutar o compilar"
        escribe_fichero(dni_alumno, "********************************************\nTEST EJERCICIO 06 - FT_PUTNBR\n********************************************\nERROR: IMPOSIBLE EJECUTAR O COMPILAR\n");
    
            
    return nota

#Acceso a la base de datos Alumnos

def lee_alumnos():
    
    global username, password, hostname, dbname;     
    #Abre la conexion
    db = MySQLdb.connect(hostname,username,password,dbname )
    #Prepara el objeto cursos para enviar comandos sql
    cursor = db.cursor()

    sql = "SELECT * FROM `alumnos`;"
    try:
            #Ejecuta comando sql
            cursor.execute(sql)
            #Guarda toda la tabla de alumnos en la lista
            alumnos = cursor.fetchall()
    except:
            print "Error: imposible recoger datos"

    #Desconecta
    db.close()
    return alumnos

def guarda_nota(alumno, nota):
    
    global username, password, hostname, dbname;
    #Abre la conexion
    db = MySQLdb.connect(hostname,username,password,dbname )

    #Prepara el objeto cursos para enviar comandos sql
    cursor = db.cursor()

    sql = "UPDATE `practica1` SET `ex00`="+str(nota[0])+", `ex01`="+str(nota[1])+", `ex02`="+str(nota[2])+", `ex03`="+str(nota[3])+", `ex04`="+str(nota[4])+", `ex05`="+str(nota[5])+", `ex06`="+str(nota[6])+" WHERE `id_alumno`="+str(alumno[0])+";"

    try:
        cursor.execute(sql)
    except:
        print "Error: imposible insertar nota"
	#Desconecta
    db.close()

## Aqui empieza la main

#Lee la base de datos

alumnos = lee_alumnos()

for alumno in alumnos:
    nota = []
    for i in range(0,7):
         nota.append(0)
    print "Turno para: "+alumno[1]
	#Clona el repositorio del alumno, la cuenta github es el campo 4 en la tabla
    clonar = Clonar("git clone https://github.com/"+alumno[4]+"/P1.git")
    if clonar.run(timeout = 10) == 0:
        #Compila y ejecuta los test, le pasamos el dni del alumno
        nota[0] = test_ex00(alumno[5])
        nota[1] = test_ex01(alumno[5])
        nota[2] = test_ex02(alumno[5])
        nota[3] = test_ex03(alumno[5])
        nota[4] = test_ex04(alumno[5])
        nota[5] = test_ex05(alumno[5])
        nota[6] = test_ex06(alumno[5])
    else:
        crea_fichero_error_clone(alumno[5])
	#Envia el correo del resultado del test al alumno
    guarda_nota(alumno, nota)
    #try:
    	#envia_correo(alumno[3], "Resultado test P1", alumno[5], "igoraresti", "pokertexas90",'smtp.gmail.com:587')
    #except:
        #print "Correo no enviado a ", alumno[3]
	#Para finalizar se borra el directorio del alumno y todos los ficheros creados
    cmd = "rm -rf P1/ "+alumno[5]
    subprocess.call(cmd, shell = True);
