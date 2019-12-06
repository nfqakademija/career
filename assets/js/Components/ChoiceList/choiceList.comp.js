import React from "react";
import { connect } from "react-redux";
import { setAnswers, removeAnswer } from "../../Actions/action";

class ChoiceList extends React.Component {
  render() {
    const { choices } = this.props;
    return (
      <select>
        {choices.map(choice => (
          <option
            onClick={() => this.props.onSetAnswers(this.props.criteriaId,choice.id)}
            key={choice.id}
            value={choice.title}
          >
            {choice.title}
          </option>
        ))}
        {console.log(this.props.answers)}
      </select>
    );
  }
}

const mapStateToProps = state => ({
  answers: state.trackUserChanges.choiceAnswers
});

const mapDispatchToProps = dispatch => ({
  onSetAnswers: (criteriaId, choiceId) => dispatch(setAnswers(criteriaId, choiceId))
});

export default connect(mapStateToProps, mapDispatchToProps)(ChoiceList);
