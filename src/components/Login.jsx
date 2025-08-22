// src/components/Login.jsx
import React, {useState} from 'react';

export default function Login() {
  const [email,setEmail] = useState('');
  const [password,setPassword] = useState('');
  const handleSubmit = e => {
    e.preventDefault();
    // call your API
    fetch('/api/auth/login', {
      method:'POST',
      headers:{'Content-Type':'application/json'},
      body: JSON.stringify({email, password})
    }).then(r=>{/* handle */});
  };
  return (
    <form onSubmit={handleSubmit}>
      <input type="email" value={email} onChange={e=>setEmail(e.target.value)} placeholder="email" required />
      <input type="password" value={password} onChange={e=>setPassword(e.target.value)} placeholder="password" required />
      <button type="submit">Login</button>
    </form>
  );
}
