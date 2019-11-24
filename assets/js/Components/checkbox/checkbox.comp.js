import React from "react";

class CheckBox extends React.Component {
  constructor() {
    super();

    this.state = {
      checked: false
    };
  }

handle = () =>{
    let actualState = !this.state.checked;
    this.setState({checked: !this.state.checked})
    if(actualState === true){
        this.props.add(this.props.competenceId, this.props.criteriaId)
    }
    else this.props.remove(this.props.competenceId, this.props.criteriaId, this.props.criteriaList);
}


  render() {
    return( 
    <div>
        <input type="checkbox" checked={this.state.checked} onChange={this.handle} />
    </div>);
  }
}

export default CheckBox;
