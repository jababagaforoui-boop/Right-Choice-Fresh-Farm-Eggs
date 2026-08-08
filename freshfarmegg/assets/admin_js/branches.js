const body=document.body;
document.getElementById("darkToggle").onclick=()=>{
    body.classList.toggle("dark");
};

function openDeliveries(id){
    fetch("?ajax_branch="+id)
    .then(r=>r.json())
    .then(d=>{
        document.getElementById("modalBranchName").innerText=d.branch.branch_name+" – Delivery Details";
        document.getElementById("modalSummary").innerHTML=`
        <div class="summary-card"><h3>Big Trays</h3><p>${d.summary.big}</p></div>
        <div class="summary-card"><h3>Small Trays</h3><p>${d.summary.small}</p></div>
        <div class="summary-card"><h3>Total Eggs</h3><p>${d.summary.eggs}</p></div>`;
        let t=`<table><tr><th>ID</th><th>Big</th><th>Small</th><th>Total Eggs</th><th>Date</th></tr>`;
        if(d.deliveries.length){
            d.deliveries.forEach(x=>{
                t+=`<tr>
                <td>${x.id}</td>
                <td>${x.big_trays}</td>
                <td>${x.small_trays}</td>
                <td>${x.big_trays*12+x.small_trays*6}</td>
                <td>${x.delivery_datetime}</td>
                </tr>`;
            });
        }else{
            t+=`<tr><td colspan="5">No deliveries found</td></tr>`;
        }
        t+=`</table>`;
        document.getElementById("modalTable").innerHTML=t;
        document.getElementById("deliveriesModal").style.display="flex";
    });
}

function closeModal(){
    document.getElementById("deliveriesModal").style.display="none";
}