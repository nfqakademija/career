import React from "react";

class CheckBox extends React.Component {
  constructor() {
    super();

    this.state = {
      checked: false
    };
  }

  handle = () => {
    let actualState = !this.state.checked;
    this.setState({ checked: !this.state.checked });
    if (actualState === true) {
      this.props.add(this.props.competenceId, this.props.criteriaId);
    } else
      this.props.remove(
        this.props.competenceId,
        this.props.criteriaId,
        this.props.criteriaList
      );
  };

  componentDidMount() {
    if (this.props.positionIncludes !== undefined) {
      for (let i = 0; i < this.props.positionIncludes.length; i++) {
        for (
          let j = 0;
          j < this.props.positionIncludes[i].criteria.length;
          j++
        ) {
          if (
            this.props.positionIncludes[i].criteria[j].title ===
            this.props.competenceName
          ) {
            this.setState({ checked: true });
          }
        }
      }
      console.log(this.props.positionIncludes);
    } else {
      this.setState({ checked: false });
    }
  }

  componentDidUpdate(prevState, currentState) {
    // console.log(prevState);
    // console.log(currentState);
    if (prevState.positionIncludes === undefined) {
      return null;
    }
    if (prevState.positionIncludes !== this.props.positionIncludes) {
      this.componentDidMount();
    }
  }

  render() {
    return (
      <div>
        <input
          type="checkbox"
          checked={this.state.checked}
          onChange={this.handle}
        />
      </div>
    );
  }
}

export default CheckBox;
