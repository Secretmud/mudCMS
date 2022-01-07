const app = document.getElementById('app');




const data = fetch('http://127.0.0.1:8080/api/content.php?type=cat&cat=test')
                .then(response => response.json())
                .then(data => console.log(data));


console.log(data)