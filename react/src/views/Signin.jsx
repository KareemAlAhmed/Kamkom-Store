import axios from 'axios';
import React, { useState } from 'react'

export default function Signin() {
  const [file, setFile] = useState(null);

  const handleFileChange = (e) => {
      setFile(e.target.files[0]);
  };

  const handleUpload =  (e) => {
    e.preventDefault();
      const formData = new FormData();
      formData.append('file', file);

      console.log(formData.get("file"))
      console.log(file)
      for(var pair of formData.entries()) {
        console.log(pair[0]+', '+pair[1]);
      }
           axios.post('http://127.0.0.1:8000/api/product/upload',formData,{
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })
           .then(res=>console.log(res))
           .catch(err=>console.log(err));
       
  };

  return (
      <div>
         <form onSubmit={handleUpload}>
          <input type="file" onChange={handleFileChange} />
            <button >Upload</button>
         </form>
      </div>
  );
  
}
