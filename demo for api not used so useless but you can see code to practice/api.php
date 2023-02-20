<?php
$url = 'http://localhost/PHP_PROJECTS/login_system/index.php?key=asjjdbdsvhbefhbbhdbvhvvbhff';

$url = "https://min-api.cryptocompare.com/data/top/totalvolfull?limit=10&tsym=USD&api_key=ea2845bebd10eacc40101c23df77167b3866442af9cc163399020c34dcfd0763";
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL ,$url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($curl);
curl_close($curl);
$result = json_decode($result,true);
echo "<pre>";
print_r($result);exit;
if(isset($result['status']))
{
    if($result['status'] == '1')
    {
        if(isset($result['result']))
        {
            if($result['result'] == 'found')
            {
                echo "<table>
            <thead >
                <tr>
                    <th>ID</th>
                    <th>Fname</th>
                    <th>Lname</th>
                    <th>Email</th>
                </tr>
            </thead>";
         echo "<tbody>";
         foreach($result['data'] as $list){ 
                echo "<tr>
                    <td>".$list['id']."</td>
                    <td>".$list['fname']."</td>
                    <td>".$list['lname']."</td>
                    <td>".$list['email']."</td>
                </tr>";
            }
            echo "</tbody>
         </table>";
                // echo "<pre>";
                // print_r($result['data']);
            }
            else
            {
                echo "<pre>";
                print_r($result['data']);
            }
        }
        else
        {   
            echo "result not found something went wrong!";
        }

    }
    else
    {
        echo "Data Not Found You have something wrong please check the error";

    }
}
else
{   
    echo "API Not Working!";

}

