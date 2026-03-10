async function addCandidate() {

    const name = document.getElementById("name").value
    const party = document.getElementById("party").value

    if (name === "" || party === "") {
        alert("Please fill all fields")
        return
    }

    const res = await fetch("../backend/elections/add_candidate.php", {

        method: "POST",

        headers: {
            "Content-Type": "application/json"
        },

        body: JSON.stringify({
            name: name,
            party: party
        })

    })

    const data = await res.json()

    alert(data.message)

    document.getElementById("name").value = ""
    document.getElementById("party").value = ""

    loadCandidates()
}



async function loadCandidates() {

    const res = await fetch("../backend/candidates/get_candidates.php")
    const data = await res.json()

    const container = document.getElementById("candidates")

    container.innerHTML = ""

    data.forEach(c => {

        container.innerHTML += `
        <div style="margin:10px 0; display:flex; justify-content:space-between; align-items:center;">

            <div>
                <b>${c.name}</b> (${c.party})
            </div>

            <button 
                onclick="deleteCandidate(${c.id})"
                style="background:#e74a3b;color:white;border:none;padding:6px 12px;border-radius:5px;cursor:pointer;">
                Delete
            </button>

        </div>
        `

    })

}



async function deleteCandidate(id) {

    if (!confirm("Are you sure you want to delete this candidate?")) return

    const res = await fetch("../backend/elections/delete_candidate.php", {

        method: "POST",

        headers: {
            "Content-Type": "application/json"
        },

        body: JSON.stringify({
            id: id
        })

    })

    const data = await res.json()

    alert(data.message)

    loadCandidates()
}



function logout() {

    window.location = "login.html"

}



loadCandidates()