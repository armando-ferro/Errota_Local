/*
 * File:   test1.c
 * Author: igor
 *
 * Created on Feb 2, 2016, 12:58:54 PM
 */
/*El test retornará el número de aciertos*/

#include <stdio.h>
#include <stdlib.h>

int ft_rev_num(int n);

int test1()
{
    if(ft_rev_num(23) == 32)
        return 1;
    return 0;
}
int test2() {
    if(ft_rev_num(-25) == -52)
        return 1;
    return 0;
}

int test3() {
    if(ft_rev_num(1080) == 801)
        return 1;
    return 0;
}

int main(int argc, char *argv[])
{
    int resultado[2]; //0 aciertos y 1 fallos

    resultado[0] = 0;
    resultado[1] = 0;
    //argv[1] es el nombre del fichero
    FILE *file = fopen(argv[1], "a" );
    fprintf(file,"********************************************\n"
            "TEST EJERCICIO 01 - FT_REV_NUM\n"
            "********************************************\n");
    fprintf(file,"Probando ft_rev_num(23)...\n");
    if(test1()==1)
    {
        fprintf(file,"OK\n");
        resultado[0] = resultado[0] + 1;
    }
    else
    {
        fprintf(file,"TEST NO SUPERADO\n");
        resultado[1] = resultado[1] + 1;
    }
    fprintf(file,"********************************************\n"
            "Probando ft_rev_num(-25)...\n");
    if(test2()==1)
    {
        fprintf(file,"OK\n");
        resultado[0] = resultado[0] + 1;
    }
    else
    {
        fprintf(file,"TEST NO SUPERADO\n");
        resultado[1] = resultado[1] + 1;
    }
    fprintf(file,"********************************************\n"
            "Probando ft_rev_num(1080)...\n");
    if(test3()==1)
    {
        fprintf(file,"OK\n");
        resultado[0] = resultado[0] + 1;
    }
    else
    {
        fprintf(file,"TEST NO SUPERADO\n");
        resultado[1] = resultado[1] + 1;
    }
    //fclose(file);
    return resultado[0];
}
