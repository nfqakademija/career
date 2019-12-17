import React from "react";
import "./hrPage.style.scss";
import CheckBox from "../../Components/checkbox/checkbox.comp";
import { connect } from "react-redux";
import { getHrPageCriterias } from "../../thunk/getHrPageCriterias";
import { getHrPagePositions } from "../../thunk/getHrPagePositions";
import {
  setCompetenceList,
  setCriteriaList,
  setCurrentPosition
} from "../../Actions/action";
import { getPositionIncludedCriterias } from "../../thunk/getPostionIncludedCriterias";
import { submitCreatedProfiles } from "../../thunk/submitCreatedProfiles";

class HrPage extends React.Component {
  constructor() {
    super();

    this.state = {
      show: []
    };
  }

  componentDidMount() {
    this.props.onSetHrPageCriterias();
    this.props.onSetHrPagePositions();
  }

  add = (competenceId, criteriaId) => {
    var joined = this.props.competenceList.concat(competenceId);
    this.props.competenceList.includes(competenceId)
      ? null
      : this.props.onSetCompetenceList(joined);

    joined = this.props.criteriaList.concat(criteriaId);
    this.props.criteriaList.includes(criteriaId)
      ? null
      : this.props.onSetCriteriaList(joined);
  };

  remove = (competenceId, criteriaId, criteriaList) => {
    let min = criteriaList[0].id;
    let max;
    let count = 0;
    criteriaList.forEach(element => (max = element.id));
    this.props.criteriaList.forEach(element => {
      if (element >= min && element <= max) {
        count++;
      }
    });

    if (count === 1) {
      let copy = [...this.props.competenceList];
      let index = copy.indexOf(competenceId);
      copy.splice(index, 1);
      this.props.onSetCompetenceList(copy);
    }

    let copy = [...this.props.criteriaList];
    let index = copy.indexOf(criteriaId);
    copy.splice(index, 1);
    this.props.onSetCriteriaList(copy);
  };

  submit = () => {
    let copy = JSON.parse(JSON.stringify(this.props.profiles));

    Array.prototype.remove = function () {
      var what,
        a = arguments,
        L = a.length,
        ax;
      while (L && this.length) {
        what = a[--L];
        while ((ax = this.indexOf(what)) !== -1) {
          this.splice(ax, 1);
        }
      }
      return this;
    };
    //if competence isn't in list it's set to 0
    copy.forEach((element, i) =>
      this.props.competenceList.includes(element.id) ? null : (copy[i] = 0)
    );

    copy.remove(0);
    //same steps but with criteria
    copy.map((data, index) =>
      data.criteriaList.map((criteria, i) => {
        this.props.criteriaList.includes(criteria.id)
          ? null
          : (copy[index].criteriaList[i] = 0);
      })
    );

    copy.map((data, index) => copy[index].criteriaList.remove(0));

    let obj = {
      position: this.props.currentPosition,
      competences: copy
    };

    if (this.props.currentPosition === null || copy.length === 0) {
      alert("Select position or criterias");
    } else {
      this.props.onSubmitCreatedProfiles(obj);
    }
  };

  positonInput = e => {
    this.props.onSetCurrentPosition(e.target.value);
    if (e.target.value !== null) {
      this.props.onGetPositionIncludedCriterias(e.target.value);
    }
  };

  toogle = i => {
    if (this.state.show.includes(i)) {
      const array = [...this.state.show];
      const index = array.indexOf(i);
      array.splice(index, 1);
      this.setState({ show: array });
    } else {
      this.setState({ show: this.state.show.concat(i) });
    }
  };

  render() {
    return (
      <div className="hrPage">
        <label>Choose position: </label>
        <select onChange={this.positonInput}>
          <option id={null} value={null}>
            --Select--
          </option>
          {this.props.positions.map(positions => (
            <option key={positions.id} value={positions.id}>
              {positions.title}
            </option>
          ))}
        </select>

        {this.props.profiles.map((competences, i) => {
          return (
            <React.Fragment key={competences.id}>
              <div className="competence">
                <h4
                  style={
                    this.state.show.includes(i)
                      ? {
                        borderBottom: "none",
                        borderRadius: "30px 30px 0px 0px"
                      }
                      : { borderRadius: "30px 30px 30px 30px" }
                  }
                  onClick={() => this.toogle(i)}
                >
                  {competences.title}
                </h4>
                {this.state.show.includes(i) ? (
                  <table>
                    <thead>
                      <tr>
                        <th>Criteria</th>
                        <th>Check to include</th>
                      </tr>
                    </thead>
                    <tbody>
                      {competences.criteriaList.map(criterias => (
                        <tr key={criterias.id}>
                          <td data-label="Criteria">{criterias.title}</td>
                          <td data-label="Check to include">
                            <CheckBox
                              add={this.add}
                              remove={this.remove}
                              competenceId={competences.id}
                              criteriaId={criterias.id}
                              criteriaList={competences.criteriaList}
                              positionIncludes={
                                this.props.positionIncludedCriterias
                              }
                              competenceName={criterias.title}
                            />
                          </td>
                        </tr>
                      ))}
                    </tbody>
                  </table>
                ) : null}
              </div>
            </React.Fragment>
          );
        })}
        <button onClick={this.submit}>Save</button>
      </div>
    );
  }
}

const mapStateToProps = state => ({
  profiles: state.hrPage.profiles,
  positions: state.hrPage.positions,
  currentPosition: state.hrPage.currentPosition,
  competenceList: state.hrPage.competenceList,
  criteriaList: state.hrPage.criteriaList,
  positionIncludedCriterias: state.hrPage.positionIncludedCriterias,
  token: state.token.token
});

const mapDispatchToProps = dispatch => ({
  onSetHrPageCriterias: () => dispatch(getHrPageCriterias()),
  onSetHrPagePositions: () => dispatch(getHrPagePositions()),
  onSetCurrentPosition: currentPosition =>
    dispatch(setCurrentPosition(currentPosition)),
  onSetCompetenceList: competenceList =>
    dispatch(setCompetenceList(competenceList)),
  onSetCriteriaList: criteriaList => dispatch(setCriteriaList(criteriaList)),
  onGetPositionIncludedCriterias: positionId =>
    dispatch(getPositionIncludedCriterias(positionId)),
  onSubmitCreatedProfiles: obj => dispatch(submitCreatedProfiles(obj))
});

export default connect(mapStateToProps, mapDispatchToProps)(HrPage);
