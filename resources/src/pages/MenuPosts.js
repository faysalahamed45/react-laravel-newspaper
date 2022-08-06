import React, { memo } from 'react';
import FirstPostDetail from '../components/PostDetails/FirstPostDetail';

const MenuPosts = () => {
 return (
  <div>
   <FirstPostDetail/>
  </div>
 );
};

export default memo(MenuPosts);