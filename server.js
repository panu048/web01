const express = require("express");
const app = express();
const port = 3000;

employees = [
    {"id":1, "name":"Somchai","position":"Manager","salary":60000},
    {"id":2, "name":"Wanpen","position":"Programmer","salary":30000},
    {"id":3, "name":"Tanapon","position":"System Analyst","salary":50000},
    {"id":4, "name":"Amnat","position":"Admin","salary":40000},
];

app.get('/',(req,res)=>{
    res.send("ยินดีต้อนรับเข้าสู่เว็บไซต์");
})

app.get('/employees',(req,res)=>{
    res.json(employees);
})

app.get('/employee/:id',(req,res)=>{
    const empid = parseInt(req.params.id);
    const employee = employees.find(e=>e.id===empid);
    res.json(employee);
})

app.get('/employee',(req,res)=>{
    const position=req.query.position;
    const filter=employees.filter(e=>e.position && e.position.toLowerCase() === position.toLowerCase());
    res.json(filter);
})

app.get('/salary',(req,res)=>{
    const min=parseFloat(req.query.min);
    const {max}=parseFloat(req.query.max);
    const filsalary= employees.filter(e=>e.salary>=min && e.salary<=max);
    res.json(filsalary);
})

app.listen(port, () =>{
    console.log("Server is Running....");
})