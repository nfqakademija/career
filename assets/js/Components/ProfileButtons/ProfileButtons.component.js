import React from "react";

const ProfileButtons = ({ name, showButton }) => {
  return (
    <div>
      <button onClick={() => showButton("showProfile")}>{name}</button>
    </div>
  );
};

export default ProfileButtons;
