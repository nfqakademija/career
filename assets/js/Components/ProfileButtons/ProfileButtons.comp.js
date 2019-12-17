import React from "react";
import "./profileButtons.style.scss";
class ProfileButtons extends React.Component {
  render() {
    const { id, name, handle } = this.props;
    return (
      <div className="profileButtons">
        <button onClick={() => handle(id)}>{name}</button>
      </div>
    );
  }
}

export default ProfileButtons;
