<?php

namespace App\Livewire\Pkl;

use Livewire\Component;
use App\Models\Pkl;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Industry;

class Edit extends Component
{
    public $pkl;
    public $student_id, $teacher_id, $industry_id;
    public $start, $end;

    public function mount($id)
    {
        $this->pkl = Pkl::findOrFail($id);

        $this->student_id = $this->pkl->student_id;
        $this->teacher_id = $this->pkl->teacher_id;
        $this->industry_id = $this->pkl->industry_id;
        $this->start = $this->pkl->start;
        $this->end = $this->pkl->end;
    }

    public function update()
    {
        $this->validate([
            'student_id'   => 'required|exists:students,id',
            'teacher_id'   => 'required|exists:teachers,id',
            'industry_id'  => 'required|exists:industries,id',
            'start'        => 'required|date|before_or_equal:end',
            'end'          => 'required|date|after_or_equal:start',
        ], [
            'start.before_or_equal' => 'Tanggal mulai tidak boleh lebih dari tanggal selesai.',
            'end.after_or_equal'    => 'Tanggal selesai tidak boleh lebih awal dari tanggal mulai.',
        ]);

        // Cek jika siswa sudah terdaftar di PKL lain
        $studentRegistered = Pkl::where('student_id', $this->student_id)
            ->where('id', '!=', $this->pkl->id)
            ->exists();

        if ($studentRegistered) {
            session()->flash('error', 'Siswa ini sudah terdaftar dalam PKL lain.');
            return;
        }

        $this->pkl->update([
            'student_id'   => $this->student_id,
            'teacher_id'   => $this->teacher_id,
            'industry_id'  => $this->industry_id,
            'start'        => $this->start,
            'end'          => $this->end,
        ]);

        session()->flash('success', 'Data PKL berhasil diperbarui.');
        return redirect()->to('/dataPkl');
    }

    public function render()
    {
        return view('livewire.pkl.edit', [
            'students'   => Student::all(),
            'teachers'   => Teacher::all(),
            'industries' => Industry::all(),
        ]);
    }
}
